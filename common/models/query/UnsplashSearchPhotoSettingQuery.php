<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\UnsplashSearchPhotoSetting]].
 *
 * @see \common\models\UnsplashSearchPhotoSetting
 */
class UnsplashSearchPhotoSettingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\UnsplashSearchPhotoSetting[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\UnsplashSearchPhotoSetting|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
