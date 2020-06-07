<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%social_network_account}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $hash_tags
 * @property string|null $comment
 * @property string $login
 * @property string $password
 * @property int $count_published
 * @property int $count_likes
 * @property int $count_subscribers
 * @property bool $is_active
 *
 * @property SocialNetworkPhoto[] $socialNetworkPhotos
 * @property UnsplashSearchPhotoSetting[] $unsplashSearchPhotoSettings
 */
class SocialNetworkAccount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%social_network_account}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'login', 'password'], 'required'],
            [['comment'], 'string'],
            [['name', 'type', 'login', 'password'], 'string', 'max' => 255],
            ['hash_tags', 'string', 'max' => 3000],
            ['is_active', 'boolean'],
            [['count_published', 'count_likes', 'count_subscribers'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'hash_tags' => Yii::t('app', 'Hash Tags'),
            'comment' => Yii::t('app', 'Comment'),
            'login' => Yii::t('app', 'Login'),
            'password' => Yii::t('app', 'Password'),
            'count_published' => Yii::t('app', 'Count Published'),
            'count_likes' => Yii::t('app', 'Count Likes'),
            'count_subscribers' => Yii::t('app', 'Count Subscribers'),
            'is_active' => Yii::t('app', 'Is Active'),
        ];
    }

    /**
     * Gets query for [[SocialNetworkPhotos]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\SocialNetworkPhotoQuery
     */
    public function getSocialNetworkPhotos()
    {
        return $this->hasMany(SocialNetworkPhoto::className(), ['social_network_account_id' => 'id']);
    }

    /**
     * Gets query for [[UnsplashSearchPhotoSettings]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UnsplashSearchPhotoSettingQuery
     */
    public function getUnsplashSearchPhotoSettings()
    {
        return $this->hasMany(UnsplashSearchPhotoSetting::className(), ['social_network_account_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\SocialNetworkAccountQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\SocialNetworkAccountQuery(get_called_class());
    }
}
