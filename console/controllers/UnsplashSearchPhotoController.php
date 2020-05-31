<?php

namespace console\controllers;

use common\models\UnsplashSearchPhoto;
use common\models\UnsplashSearchPhotoRequest;
use common\services\Unsplash;
use Exception;
use Yii;
use yii\console\Controller;
use common\models\UnsplashSearchPhotoSetting;
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

            // берем последний запрос
            $lastRequest = $setting->getUnsplashSearchPhotoRequests()
                ->orderBy(['created_at' => SORT_DESC])
                ->one();

            // страница для следующего запроса
            $page = !$lastRequest ? 1 : ++$lastRequest->page;

            try {
                // запрос на API unsplash
                $searchPhotoResult = $unsplash->searchPhotos(
                    $setting->search,
                    $page,
                    $setting->per_page,
                    $setting->collections,
                    $setting->orientation
                );

                $this->stdout("Unsplash photo search request handled\n", Console::FG_GREEN);
            } catch (Exception $e) {
                // todo: отправить уведомление
                $this->stdout(sprintf("Unsplash photo search request error message: %s\n", $e->getMessage()), Console::FG_RED);
                continue;
            }

            $countResult = count($searchPhotoResult->getResults());

            // результат без фото
            if (0 === $countResult) {
                // todo: отправить уведомление

                $setting->is_finished = true;
                $setting->save();

                $this->stdout("Total result photo: 0\n", Console::FG_RED);
                continue;
            }

            $this->stdout("Total result photo: $countResult.\n", Console::FG_GREEN);

            $newRequest = new UnsplashSearchPhotoRequest();
            $newRequest->setting_id = $setting->id;
            $newRequest->page = $page;
            $newRequest->count_result = $countResult;

            Yii::$app->db->beginTransaction();

            try {
                // сохраняем запрос
                $newRequest->save();
                $this->stdout("Request saved\n", Console::FG_GREEN);

                // сохраняем все фото
                foreach ($searchPhotoResult->getResults() as $key => $photoData) {
                    $unsplashSearchPhoto = new UnsplashSearchPhoto();
                    $unsplashSearchPhoto->setting_id = $setting->id;
                    $unsplashSearchPhoto->request_id = $newRequest->id;
                    $unsplashSearchPhoto->unsplash_id = $photoData['id'];
                    $unsplashSearchPhoto->raw_url = $photoData['urls']['raw'];
                    $unsplashSearchPhoto->description = $photoData['alt_description'] ?? $photoData['description'] ?? null;
                    $unsplashSearchPhoto->width = $photoData['width'] ?? null;
                    $unsplashSearchPhoto->height = $photoData['height'] ?? null;
                    $unsplashSearchPhoto->downloaded_at = null;

                    $unsplashSearchPhoto->save();
                    $this->stdout(($key + 1) . " photo saved\n", Console::FG_GREEN);
                }

                Yii::$app->db->transaction->commit();
            } catch (Exception $e) {
                Yii::$app->db->transaction->rollBack();

                $this->stdout(sprintf("DB error message: %s\n", $e->getMessage()), Console::FG_RED);
                continue;
            }
        }

        $this->stdout("Finished!\n", Console::FG_GREEN);
    }
}
