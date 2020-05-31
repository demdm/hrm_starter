<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%unsplash_search_photo_request}}".
 *
 * @property int $id
 * @property int $setting_id
 * @property int $page
 * @property int $count_result
 * @property string $created_at
 *
 * @property UnsplashSearchPhotoSetting $setting
 * @property UnsplashSearchPhoto[] $unsplashSearchPhotos
 */
class UnsplashSearchPhotoRequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%unsplash_search_photo_request}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['setting_id', 'page'], 'required'],
            [['setting_id', 'page', 'count_result'], 'integer'],
            [['created_at'], 'safe'],
            [['setting_id'], 'exist', 'skipOnError' => true, 'targetClass' => UnsplashSearchPhotoSetting::className(), 'targetAttribute' => ['setting_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'setting_id' => Yii::t('app', 'Setting ID'),
            'page' => Yii::t('app', 'Page'),
            'count_result' => Yii::t('app', 'Count Result'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Gets query for [[Setting]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UnsplashSearchPhotoSettingQuery
     */
    public function getSetting()
    {
        return $this->hasOne(UnsplashSearchPhotoSetting::className(), ['id' => 'setting_id']);
    }

    /**
     * Gets query for [[UnsplashSearchPhotos]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UnsplashSearchPhotoQuery
     */
    public function getUnsplashSearchPhotos()
    {
        return $this->hasMany(UnsplashSearchPhoto::className(), ['request_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\UnsplashSearchPhotoRequestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\UnsplashSearchPhotoRequestQuery(get_called_class());
    }
}
