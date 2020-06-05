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
            ->joinWith(
                'setting setting',
                false
            )
            ->where([
                'downloaded_at' => null,
                'setting.is_active' => true,
            ])
            ->orderBy(['created_at' => SORT_ASC])
            ->all();

        $this->stdout(sprintf("Count photos: %d\n", count($unsplashPhotoList)), Console::FG_YELLOW);

        foreach ($unsplashPhotoList as $key => $unsplashPhoto) {
            $this->stdout(sprintf("Searched by: %s\n", $unsplashPhoto->setting->search), Console::FG_YELLOW);

            $filename = Yii::getAlias("@storage/photoStock/unsplash/{$unsplashPhoto->unsplash_id}.jpg");

            $isPhotoDownloaded = file_put_contents(
                $filename,
                file_get_contents($unsplashPhoto->raw_url)
            );

            if (false === $isPhotoDownloaded || 0 === $isPhotoDownloaded) {
                $this->stdout("Photo downloading failed", Console::FG_RED);
                continue;
            }

            $this->stdout("Photo downloaded\n", Console::FG_GREEN);

            $socialNetworkPhoto = new SocialNetworkPhoto();
            $socialNetworkPhoto->social_network_account_id = $unsplashPhoto->setting->social_network_account_id;
            $socialNetworkPhoto->filename = $filename;
            $socialNetworkPhoto->file_caption = $unsplashPhoto->description;
            $socialNetworkPhoto->hash_tags = null;

            $unsplashPhoto->downloaded_at = date('Y-m-d H:i:s');

            Yii::$app->db->beginTransaction();

            try {
                $unsplashPhoto->save();
                $socialNetworkPhoto->save();

                Yii::$app->db->transaction->commit();
            } catch (\Exception $e) {
                Yii::$app->db->transaction->rollBack();

                $this->stdout(sprintf("DB error message: %s", $e->getMessage()), Console::FG_RED);

                if (file_exists($filename)) {
                    unlink($filename);
                }
            }

            $this->stdout(" - - - - - \n");
        }

        $this->stdout("Finished!\n", Console::FG_GREEN);
    }
}