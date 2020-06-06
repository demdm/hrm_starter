<?php

namespace console\controllers;

use common\models\SocialNetworkAccount;
use common\services\Instagram;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class SocialNetworkPublishPhotoController extends Controller
{
    public function actionIndex()
    {
        $this->stdout("Publishing...\n", Console::FG_YELLOW);

        $accountList = SocialNetworkAccount::find()
            ->where(['is_active' => true])
            ->all();

        if (empty($accountList)) {
            $this->stdout("Account: not found\n", Console::FG_RED);
        }

        $totalCountPhoto = 0;
        $totalCountPhotoDownloaded = 0;
        $totalCountPhotoSkipped = 0;

        foreach ($accountList as $account) {
            $photoList = $account->getSocialNetworkPhotos()
                ->where([
                    'posted_at' => null,
                    'is_skipped' => null,
                ])
                ->orderBy([
                    'created_at' => SORT_ASC,
                ])
                ->all()
            ;

            $instagram = new Instagram($account->login, $account->password);
            $accountHashTagList = array_unique(array_diff(explode(' ', $account->hash_tags), ['']));

            $countPhotoDownloaded = 0;
            $countPhotoSkipped = 0;

            $this->stdout(sprintf("[%s]: publishing", $account->name), Console::FG_GREEN);

            foreach ($photoList as $photo) {
                shuffle($accountHashTagList);
                $photoHashTagList = array_slice($accountHashTagList,0,28);
                $photoCaption = $photo->file_caption
                    . ($photo->file_caption ? ' ' : '')
                    . '#' . implode(' #', $photoHashTagList);

                try {
                    $publishedPhotoId = $instagram->publishPhoto($photo->filename, $photoCaption);
                } catch (\Exception $e) {
                    $photo->skip_message = $e->getMessage();
                    $publishedPhotoId = null;
                }

                // фото не опубликовано
                if (null === $publishedPhotoId) {
                    $photo->is_skipped = true;
                    $account->count_skipped++;

                    $countPhotoSkipped++;
                    $totalCountPhotoSkipped++;
                    $this->stdout(".", Console::FG_RED);
                } else {
                    // не факт, что опубликовано - инстаграм иногда врет

                    $photo->hash_tags = !empty($hashTagList) ? implode(' ', $hashTagList) : null;
                    $photo->posted_at = date('Y-m-d H:i:s');
                    $photo->social_network_photo_id = $publishedPhotoId;
                    $account->count_published++;

                    $countPhotoDownloaded++;
                    $totalCountPhotoDownloaded++;
                    $this->stdout(".", Console::FG_GREEN);
                }

                unlink($photo->filename);
                $photo->filename = null;
                $photo->save();
            }

            $account->save();

            $this->stdout(
                sprintf(
                    "\n[%s]: all %d, downloaded %d, skipped %d\n",
                    $account->name,
                    count($photoList),
                    $countPhotoDownloaded,
                    $countPhotoSkipped
                ),
                Console::FG_GREEN
            );
        }

        $this->stdout(
            sprintf(
                "Total: all %d, downloaded %d, skipped %d\n",
                $totalCountPhoto,
                $totalCountPhotoDownloaded,
                $totalCountPhotoSkipped
            ),
            Console::FG_GREEN
        );

        $this->stdout("Publishing finished!\n", Console::FG_YELLOW);
    }
}
