<?php

namespace console\controllers;

use common\models\SocialNetworkPhoto;
use common\services\Instagram;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class SocialNetworkPublishPhotoController extends Controller
{
    public function actionIndex()
    {
        $socialNetworkPhoto = SocialNetworkPhoto::find()
            ->joinWith(
                'socialNetworkAccount socialNetworkAccount',
                false
            )
            ->where([
                'socialNetworkAccount.is_active' => true,
                'posted_at' => null,
                'is_skipped' => null,
            ])
            ->orderBy(['created_at' => SORT_ASC])
            ->one()
        ;

        if (!$socialNetworkPhoto) {
            $this->stdout("No one photo found\n", Console::FG_GREEN);
            return;
        }

        $instagram = new Instagram(
            $socialNetworkPhoto->socialNetworkAccount->login,
            $socialNetworkPhoto->socialNetworkAccount->password
        );

        try {
            $publishedSocialNetworkPhotoId = $instagram->publishPhoto(
                $socialNetworkPhoto->filename,
                $socialNetworkPhoto->file_caption
            );
        } catch (\Exception $e) {
            $this->stdout(sprintf("Instagram error: %s\n", $e->getMessage()), Console::FG_RED);

            $publishedSocialNetworkPhotoId = null;

            // пропускаем фото и сохраняем ошибку, если инстаграм отвис
            $socialNetworkPhoto->skip_message = $e->getMessage();
        }

        $filename = $socialNetworkPhoto->filename;

        // фото не опубликовано
        if (null === $publishedSocialNetworkPhotoId) {
            $socialNetworkPhoto->is_skipped = true;
            $socialNetworkPhoto->socialNetworkAccount->count_skipped++;

            $this->stdout("Photo publishing skipped\n", Console::FG_RED);
        } else {
            $socialNetworkPhoto->posted_at = date('Y-m-d H:i:s');
            $socialNetworkPhoto->filename = null;
            $socialNetworkPhoto->social_network_photo_id = $publishedSocialNetworkPhotoId;
            $socialNetworkPhoto->socialNetworkAccount->count_published++;

            $this->stdout("Photo published\n", Console::FG_GREEN);
        }

        Yii::$app->db->beginTransaction();
        try {
            $socialNetworkPhoto->socialNetworkAccount->save();
            $socialNetworkPhoto->save();

            // удаляем фото
            $isPhotoRemoved = unlink($filename);
            if (!$isPhotoRemoved) {
                $this->stdout("Photo removing failed\n", Console::FG_RED);
            }

            Yii::$app->db->transaction->commit();
        } catch (\Exception $e) {
            Yii::$app->db->transaction->rollBack();

            $this->stdout(sprintf("DB error message: %s", $e->getMessage()), Console::FG_RED);
        }

        $this->stdout("Finished!\n", Console::FG_GREEN);
    }
}
