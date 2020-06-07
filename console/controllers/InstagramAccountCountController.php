<?php

namespace console\controllers;

use common\models\SocialNetworkAccount;
use common\services\Instagram;
use yii\console\Controller;
use yii\helpers\Console;

class InstagramAccountCountController extends Controller
{
    public function actionIndex()
    {
        $this->stdout("Counting...\n", Console::FG_YELLOW);

        $accountList = SocialNetworkAccount::find()
            ->where(['is_active' => true])
            ->all();

        if (empty($accountList)) {
            $this->stdout("Account: not found\n", Console::FG_RED);
        }

        foreach ($accountList as $account) {
            $instagram = new Instagram($account->login, $account->password);
            $medias = $instagram->getMyMedias();

            $countPublished = count($medias);

            $countLikes = 0;
            foreach ($medias as $media) {
                $countLikes += $media->getLikesCount();
            }

            $account->count_likes = $countLikes;
            $account->count_published = $countPublished;
            $account->save();

            $this->stdout(
                sprintf(
                    "[%s]: published %d, likes %d\n",
                    $account->name,
                    $account->count_published,
                    $countLikes
                ),
                Console::FG_GREEN
            );
        }

        $this->stdout("Counting finished!\n", Console::FG_YELLOW);
    }
}
