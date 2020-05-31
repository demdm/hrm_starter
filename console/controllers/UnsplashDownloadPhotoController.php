<?php

namespace console\controllers;

use common\models\SocialNetworkPhoto;
use common\models\UnsplashSearchPhoto;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class UnsplashDownloadPhotoController extends Controller
{
    public function actionIndex()
    {
        $unsplashPhotoList = UnsplashSearchPhoto::find()
            ->with('setting')
            ->where(['downloaded_at' => null])
            ->orderBy(['created_at' => SORT_ASC])
            ->all();

        foreach ($unsplashPhotoList as $key => $unsplashPhoto) {
            $filename = Yii::getAlias("@storage/photoStock/unsplash/{$unsplashPhoto->unsplash_id}.jpg");

            $isPhotoDownloaded = file_put_contents(
                $filename,
                file_get_contents($unsplashPhoto->raw_url)
            );

            if (false === $isPhotoDownloaded || $isPhotoDownloaded === 0) {
                $this->stdout("Photo downloading error", Console::FG_RED);
                continue;
            }

            $socialNetworkPhoto = new SocialNetworkPhoto();
            $socialNetworkPhoto->social_network_account_id = $unsplashPhoto->setting->social_network_account_id;
            $socialNetworkPhoto->filename = $filename;
            $socialNetworkPhoto->file_caption = $unsplashPhoto->description;

            $unsplashPhoto->downloaded_at = date('Y-m-d H:i:s');

            Yii::$app->db->beginTransaction();

            try {
                $unsplashPhoto->save();
                $socialNetworkPhoto->save();

                $this->stdout(($key + 1) . " photo downloaded\n", Console::FG_GREEN);

                Yii::$app->db->transaction->commit();
            } catch (\Exception $e) {
                Yii::$app->db->transaction->rollBack();

                $this->stdout(sprintf("DB error message: %s", $e->getMessage()), Console::FG_RED);

                unlink($filename);
            }
        }
    }
}