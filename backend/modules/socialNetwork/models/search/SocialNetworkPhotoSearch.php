<?php

namespace backend\modules\socialNetwork\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SocialNetworkPhoto;

/**
 * SocialNetworkPhotoSearch represents the model behind the search form about `common\models\SocialNetworkPhoto`.
 */
class SocialNetworkPhotoSearch extends SocialNetworkPhoto
{
    /**
     * @var string|null ['0', '1', null]
     */
    public $is_posted;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'social_network_account_id'], 'integer'],
            [['filename', 'file_caption', 'posted_at', 'created_at'], 'safe'],
            [['is_posted', 'is_skipped'], 'boolean'],
            ['social_network_photo_id', 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SocialNetworkPhoto::find()->with('socialNetworkAccount');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if ('1' === $this->is_posted) {
            $query->andWhere(['not', ['posted_at' => null]]);
        }

        $query
            ->andFilterWhere([
                'id' => $this->id,
                'is_skipped' => $this->is_skipped,
                'social_network_account_id' => $this->social_network_account_id,
                // 'posted_at' => $this->posted_at,
                'created_at' => $this->created_at,
            ])
            ->andFilterWhere(['like', 'social_network_photo_id', $this->social_network_photo_id])
            ->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'file_caption', $this->file_caption])
        ;

        return $dataProvider;
    }
}
