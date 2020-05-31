<?php

namespace backend\modules\unsplashSearchPhoto\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UnsplashSearchPhoto;

/**
 * UnsplashSearchPhotoSearch represents the model behind the search form about `common\models\UnsplashSearchPhoto`.
 */
class UnsplashSearchPhotoSearch extends UnsplashSearchPhoto
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'setting_id', 'request_id', 'width', 'height'], 'integer'],
            [['unsplash_id', 'raw_url', 'description', 'downloaded_at', 'created_at'], 'safe'],
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
        $query = UnsplashSearchPhoto::find();

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

        $query->andFilterWhere([
            'id' => $this->id,
            'setting_id' => $this->setting_id,
            'request_id' => $this->request_id,
            'width' => $this->width,
            'height' => $this->height,
            'downloaded_at' => $this->downloaded_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'unsplash_id', $this->unsplash_id])
            ->andFilterWhere(['like', 'raw_url', $this->raw_url])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
