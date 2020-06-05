<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%social_network_photo}}".
 *
 * @property int $id
 * @property int $social_network_account_id
 * @property string|null $social_network_photo_id
 * @property string|null $filename
 * @property string|null $file_caption
 * @property string|null $hash_tags
 * @property bool $is_skipped
 * @property string|null $skip_message
 * @property string|null $posted_at
 * @property string $created_at
 *
 * @property SocialNetworkAccount $socialNetworkAccount
 */
class SocialNetworkPhoto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%social_network_photo}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['social_network_account_id'], 'required'],
            [['social_network_account_id'], 'integer'],
            ['is_skipped', 'boolean'],
            [['posted_at', 'created_at'], 'safe'],
            [['filename', 'file_caption', 'skip_message', 'social_network_photo_id'], 'string', 'max' => 255],
            ['hash_tags', 'string', 'max' => 3000],
            [['social_network_account_id'], 'exist', 'skipOnError' => true, 'targetClass' => SocialNetworkAccount::class, 'targetAttribute' => ['social_network_account_id' => 'id']],
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
            'social_network_photo_id' => Yii::t('app', 'Social Network Photo ID'),
            'filename' => Yii::t('app', 'Filename'),
            'file_caption' => Yii::t('app', 'File Caption'),
            'hash_tags' => Yii::t('app', 'Hash Tags'),
            'is_skipped' => Yii::t('app', 'Is Skipped'),
            'skip_message' => Yii::t('app', 'Skip Message'),
            'posted_at' => Yii::t('app', 'Posted At'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Gets query for [[SocialNetworkAccount]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\SocialNetworkAccountQuery
     */
    public function getSocialNetworkAccount()
    {
        return $this->hasOne(SocialNetworkAccount::class, ['id' => 'social_network_account_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\SocialNetworkPhotoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\SocialNetworkPhotoQuery(get_called_class());
    }
}
