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
        // получаем настройки
        $settingList = UnsplashSearchPhotoSetting::find()
            ->where([
                'is_active' => true,
                'is_finished' => false,
            ])
            ->all();

        $unsplash = new Unsplash();

        foreach ($settingList as $setting) {
            if ($setting->is_finished) {
                continue;
            }

            $this->stdout(sprintf("Search by: %s\n", $setting->search), Console::FG_YELLOW);

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

                $this->stdout("Photo searched\n", Console::FG_GREEN);
            } catch (Exception $e) {
                // todo: отправить уведомление

                $this->stdout(sprintf("Unsplash error: %s\n", $e->getMessage()), Console::FG_RED);

                continue;
            }

            $countResult = count($searchPhotoResult->getResults());

            $this->stdout(sprintf("Count photos: %d\n", $countResult), Console::FG_YELLOW);

            // результат без фото
            if (0 === $countResult) {
                // todo: отправить уведомление

                $setting->is_finished = true;
                $setting->save();

                continue;
            }

            $newRequest = new UnsplashSearchPhotoRequest();
            $newRequest->setting_id = $setting->id;
            $newRequest->page = $page;
            $newRequest->count_result = $countResult;

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

                    $isSaved = $unsplashSearchPhoto->save();
                    if ($isSaved) {
                        $this->stdout("Photo saved\n", Console::FG_GREEN);
                    } else {
                        $this->stdout(
                            sprintf(
                                "DB validation failed: %s\n",
                                print_r($unsplashSearchPhoto->errors, true)
                            ),
                            Console::FG_RED
                        );
                    }
                }

                Yii::$app->db->transaction->commit();

                $this->stdout("Request saved\n", Console::FG_GREEN);
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

            $this->stdout(" - - - - - \n");
        }

        $this->stdout("Finished!\n", Console::FG_GREEN);
    }
}
