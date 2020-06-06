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
        $this->stdout("Downloading...\n", Console::FG_YELLOW);

        $unsplashPhotoList = UnsplashSearchPhoto::find()
            ->joinWith(
                'setting setting',
                false
            )
            ->where([
                'downloaded_at' => null,
                'setting.is_active' => true,
            ])
            ->orderBy([
                'setting.id' => SORT_DESC,
                'created_at' => SORT_ASC,
            ])
            ->all();

        $totalCountPhotoFailed = 0;
        $totalCountPhotoDownloaded = 0;

        foreach ($unsplashPhotoList as $key => $unsplashPhoto) {
            $filename = Yii::getAlias("@storage/photoStock/unsplash/{$unsplashPhoto->unsplash_id}.jpg");

            $isPhotoDownloaded = file_put_contents(
                $filename,
                file_get_contents($unsplashPhoto->raw_url)
            );

            if (false === $isPhotoDownloaded || 0 === $isPhotoDownloaded) {
                $totalCountPhotoFailed++;
                continue;
            }

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

                $totalCountPhotoDownloaded++;

                $this->stdout(sprintf("[%s]: downloaded\n", $unsplashPhoto->setting->search), Console::FG_GREEN);
            } catch (\Exception $e) {
                Yii::$app->db->transaction->rollBack();

                if (file_exists($filename)) {
                    unlink($filename);
                }

                $totalCountPhotoFailed++;
            }
        }

        $this->stdout(
            sprintf(
                "Total: all %d, downloaded %d, failed %d\n",
                count($unsplashPhotoList),
                $totalCountPhotoDownloaded,
                $totalCountPhotoFailed
            ),
            Console::FG_GREEN
        );

        $this->stdout("Downloading finished!\n\n", Console::FG_YELLOW);
    }
}