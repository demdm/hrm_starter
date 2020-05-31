<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%unsplash_search_photo}}".
 *
 * @property int $id
 * @property int $setting_id
 * @property int $request_id
 * @property string $unsplash_id
 * @property string $raw_url
 * @property string|null $description
 * @property int|null $width
 * @property int|null $height
 * @property string|null $downloaded_at
 * @property string $created_at
 *
 * @property UnsplashSearchPhotoRequest $request
 * @property UnsplashSearchPhotoSetting $setting
 */
class UnsplashSearchPhoto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%unsplash_search_photo}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['setting_id', 'request_id', 'unsplash_id', 'raw_url'], 'required'],
            [['setting_id', 'request_id', 'width', 'height'], 'integer'],
            [['raw_url', 'description'], 'string'],
            [['downloaded_at', 'created_at'], 'safe'],
            [['unsplash_id'], 'string', 'max' => 255],
            [['unsplash_id'], 'unique'],
            [['request_id'], 'exist', 'skipOnError' => true, 'targetClass' => UnsplashSearchPhotoRequest::className(), 'targetAttribute' => ['request_id' => 'id']],
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
            'request_id' => Yii::t('app', 'Request ID'),
            'unsplash_id' => Yii::t('app', 'Unsplash ID'),
            'raw_url' => Yii::t('app', 'Raw Url'),
            'description' => Yii::t('app', 'Description'),
            'width' => Yii::t('app', 'Width'),
            'height' => Yii::t('app', 'Height'),
            'downloaded_at' => Yii::t('app', 'Downloaded At'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Gets query for [[Request]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UnsplashSearchPhotoRequestQuery
     */
    public function getRequest()
    {
        return $this->hasOne(UnsplashSearchPhotoRequest::className(), ['id' => 'request_id']);
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
     * {@inheritdoc}
     * @return \common\models\query\UnsplashSearchPhotoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\UnsplashSearchPhotoQuery(get_called_class());
    }
}
