<?php

namespace console\controllers;

use common\models\UnsplashSearchPhoto;
use common\models\UnsplashSearchPhotoRequest;
use common\models\UnsplashSearchPhotoSetting;
use common\services\Unsplash;
use Exception;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class UnsplashSearchPhotoController extends Controller
{
    public function actionIndex()
    {
        $this->stdout("Searching...\n", Console::FG_YELLOW);

        // получаем настройки
        $settingList = UnsplashSearchPhotoSetting::find()
            ->with('socialNetworkAccount')
            ->where([
                'is_active' => true,
                'is_finished' => false,
            ])
            ->all();

        $totalCountPhoto = 0;
        $totalCountPhotoSaved = 0;
        $totalCountPhotoSkipped = 0;

        $unsplash = new Unsplash();

        foreach ($settingList as $setting) {
            if ($setting->is_finished) {
                continue;
            }

            if (!$setting->socialNetworkAccount->is_active) {
                continue;
            }

            // берем последний запрос
            $lastRequest = $setting->getUnsplashSearchPhotoRequests()
                ->orderBy(['created_at' => SORT_DESC])
                ->one();

            // страница для нового запроса
            $page = $lastRequest ? ++$lastRequest->page : 1;

            try {
                // запрос на API unsplash
                $searchPhotoResult = $unsplash->searchPhotos(
                    $setting->search,
                    $page,
                    $setting->per_page,
                    $setting->collections,
                    $setting->orientation
                );
            } catch (Exception $e) {
                $this->stdout(sprintf("Unsplash error: %s\n", $e->getMessage()), Console::FG_RED);
                continue;
            }

            $countResult = count($searchPhotoResult->getResults());

            // результат без фото
            if (0 === $countResult) {
                $this->stdout(sprintf("[%s]: finished\n", $setting->search), Console::FG_RED);

                $setting->is_finished = true;
                $setting->save();
                continue;
            }

            $newRequest = new UnsplashSearchPhotoRequest();
            $newRequest->setting_id = $setting->id;
            $newRequest->page = $page;
            $newRequest->count_result = $countResult;

            $countPhotoSaved = 0;
            $countPhotoSkipped = 0;

            Yii::$app->db->beginTransaction();

            try {
                // сохраняем запрос
                $newRequest->save();

                // сохраняем все фото
                foreach ($searchPhotoResult->getResults() as $photoData) {
                    $unsplashSearchPhoto = new UnsplashSearchPhoto();
                    $unsplashSearchPhoto->setting_id = $setting->id;
                    $unsplashSearchPhoto->request_id = $newRequest->id;
                    $unsplashSearchPhoto->unsplash_id = $photoData['id'];
                    $unsplashSearchPhoto->raw_url = $photoData['urls']['raw'];
                    $unsplashSearchPhoto->description = $photoData['alt_description']
                        ?? $photoData['description']
                        ?? null;
                    $unsplashSearchPhoto->width = $photoData['width'] ?? null;
                    $unsplashSearchPhoto->height = $photoData['height'] ?? null;
                    $unsplashSearchPhoto->downloaded_at = null;

                    $unsplashSearchPhoto->save()
                        ? $countPhotoSaved++
                        : $countPhotoSkipped++;
                }

                Yii::$app->db->transaction->commit();
            } catch (Exception $e) {
                Yii::$app->db->transaction->rollBack();

                $this->stdout(
                    sprintf(
                        "DB error: %s\nTrace: %s\n",
                        $e->getMessage(),
                        $e->getTraceAsString()
                    ),
                    Console::FG_RED
                );
            }

            $totalCountPhoto += $countResult;
            $totalCountPhotoSaved += $countPhotoSaved;
            $totalCountPhotoSkipped += $countPhotoSkipped;

            $this->stdout(
                sprintf(
                    "[%s]: all %d, saved %d, skipped %d\n",
                    $setting->search,
                    $countResult,
                    $countPhotoSaved,
                    $countPhotoSkipped
                ),
                Console::FG_GREEN
            );
        }

        $this->stdout(
            sprintf(
                "Total: all %d, saved %d, skipped %d\n",
                $totalCountPhoto,
                $totalCountPhotoSaved,
                $totalCountPhotoSkipped
            ),
            Console::FG_GREEN
        );

        $this->stdout("Searching finished!\n\n", Console::FG_YELLOW);
    }
}
