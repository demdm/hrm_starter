<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%unsplash_search_photo_setting}}".
 *
 * @property int $id
 * @property int $social_network_account_id
 * @property string $name
 * @property string $search
 * @property int $per_page
 * @property string|null $orientation
 * @property string|null $collections
 * @property string|null $comment
 * @property bool $is_active
 * @property bool $is_finished
 *
 * @property SocialNetworkAccount $socialNetworkAccount
 * @property UnsplashSearchPhotoRequest[] $unsplashSearchPhotoRequests
 * @property UnsplashSearchPhoto[] $unsplashSearchPhotos
 */
class UnsplashSearchPhotoSetting extends \yii\db\ActiveRecord
{
    const ORIENTATION_LANDSCAPE = 'landscape';
    const ORIENTATION_PORTRAIT = 'portrait';
    const ORIENTATION_SQUARISH = 'squarish';
    const ORIENTATION_LIST = [
        self::ORIENTATION_LANDSCAPE => 'Landscape',
        self::ORIENTATION_PORTRAIT => 'Portrait',
        self::ORIENTATION_SQUARISH => 'Squarish',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%unsplash_search_photo_setting}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['social_network_account_id', 'name', 'search', 'per_page'], 'required'],
            [['social_network_account_id', 'per_page'], 'integer'],
            [['name', 'search', 'orientation', 'collections'], 'string', 'max' => 255],
            ['comment', 'string'],
            [['is_active', 'is_finished'], 'boolean'],
            [['social_network_account_id'], 'exist', 'skipOnError' => true, 'targetClass' => SocialNetworkAccount::className(), 'targetAttribute' => ['social_network_account_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'social_network_account_id' => Yii::t('app', 'Social Network Account ID'),
            'name' => Yii::t('app', 'Name'),
            'search' => Yii::t('app', 'Search'),
            'per_page' => Yii::t('app', 'Per Page'),
            'orientation' => Yii::t('app', 'Orientation'),
            'collections' => Yii::t('app', 'Collections'),
            'comment' => Yii::t('app', 'Comment'),
            'is_active' => Yii::t('app', 'Is Active'),
            'is_finished' => Yii::t('app', 'Is Finished'),
        ];
    }

    /**
     * Gets query for [[SocialNetworkAccount]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\SocialNetworkAccountQuery
     */
    public function getSocialNetworkAccount()
    {
        return $this->hasOne(SocialNetworkAccount::className(), ['id' => 'social_network_account_id']);
    }

    /**
     * Gets query for [[UnsplashSearchPhotoRequests]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UnsplashSearchPhotoRequestQuery
     */
    public function getUnsplashSearchPhotoRequests()
    {
        return $this->hasMany(UnsplashSearchPhotoRequest::className(), ['setting_id' => 'id']);
    }

    /**
     * Gets query for [[UnsplashSearchPhotos]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UnsplashSearchPhotoQuery
     */
    public function getUnsplashSearchPhotos()
    {
        return $this->hasMany(UnsplashSearchPhoto::className(), ['setting_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\UnsplashSearchPhotoSettingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\UnsplashSearchPhotoSettingQuery(get_called_class());
    }
}
