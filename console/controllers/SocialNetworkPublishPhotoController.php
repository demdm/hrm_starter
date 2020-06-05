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
        $socialNetworkPhotoList = SocialNetworkPhoto::find()
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
            ->all()
        ;

        if (empty($socialNetworkPhotoList)) {
            $this->stdout("No one photo found\n", Console::FG_GREEN);
            return;
        }

        /** @var Instagram[] $indexedByIdInstagram */
        $indexedByIdInstagram = [];

        /** @var array[] $indexedByIdHashTags */
        $indexedByIdHashTags = [];

        foreach ($socialNetworkPhotoList as $socialNetworkPhoto) {
            $socialNetworkAccount = $socialNetworkPhoto->socialNetworkAccount;

            if (!isset($indexedByIdInstagram[$socialNetworkAccount->id])) {
                $indexedByIdInstagram[$socialNetworkAccount->id] = new Instagram(
                    $socialNetworkAccount->login,
                    $socialNetworkAccount->password
                );
            }

            $photoCaption = $socialNetworkPhoto->file_caption ?: '';

            // добавляем хеш теги
            $hashTagList = [];
            if ($socialNetworkAccount->hash_tags) {
                if (!isset($indexedByIdHashTags[$socialNetworkAccount->id])) {
                    $indexedByIdHashTags[$socialNetworkAccount->id] = array_unique(
                        array_diff(
                            explode(' ', $socialNetworkAccount->hash_tags),
                            ['']
                        )
                    );
                }

                // перемешали и обрезали массив
                shuffle($indexedByIdHashTags[$socialNetworkAccount->id]);
                $hashTagList = array_slice(
                    $indexedByIdHashTags[$socialNetworkAccount->id],
                    0,
                    28
                ); // 28 - максимальное число хеш тегов для фото

                $photoCaption .= ($photoCaption ? ' ' : '') . '#' . implode(' #', $hashTagList);
            }

            $instagram = $indexedByIdInstagram[$socialNetworkAccount->id];

            try {
                $publishedSocialNetworkPhotoId = $instagram->publishPhoto(
                    $socialNetworkPhoto->filename,
                    $photoCaption
                );
            } catch (\Exception $e) {
                $publishedSocialNetworkPhotoId = null;

                // пропускаем фото и сохраняем ошибку, если инстаграм отвис
                $socialNetworkPhoto->skip_message = $e->getMessage();
            }

            // фото не опубликовано
            if (null === $publishedSocialNetworkPhotoId) {
                $socialNetworkPhoto->is_skipped = true;
                $socialNetworkAccount->count_skipped++;

                $this->stdout("Photo skipped\n", Console::FG_RED);
            } else {
                // не факт, что опубликовано
                // инстаграм врет
                $socialNetworkPhoto->hash_tags = !empty($hashTagList) ? implode(' ', $hashTagList) : null;
                $socialNetworkPhoto->posted_at = date('Y-m-d H:i:s');
                $socialNetworkPhoto->social_network_photo_id = $publishedSocialNetworkPhotoId;
                $socialNetworkAccount->count_published++;

                $this->stdout("Photo published\n", Console::FG_GREEN);
            }

            Yii::$app->db->beginTransaction();

            try {
                $socialNetworkAccount->save();

                // удаляем фото
                unlink($socialNetworkPhoto->filename);

                $socialNetworkPhoto->filename = null;
                $socialNetworkPhoto->save();

                Yii::$app->db->transaction->commit();
            } catch (\Exception $e) {
                Yii::$app->db->transaction->rollBack();

                $this->stdout(sprintf("DB error: %s", $e->getMessage()), Console::FG_RED);
            }
        }

        $this->stdout("Finished!\n", Console::FG_GREEN);
    }
}
