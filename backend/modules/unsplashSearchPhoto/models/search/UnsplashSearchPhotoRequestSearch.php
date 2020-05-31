<?php

namespace backend\modules\unsplashSearchPhoto\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UnsplashSearchPhotoRequest;

/**
 * UnsplashSearchPhotoRequestSearch represents the model behind the search form about `common\models\UnsplashSearchPhotoRequest`.
 */
class UnsplashSearchPhotoRequestSearch extends UnsplashSearchPhotoRequest
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'setting_id', 'page', 'count_result'], 'integer'],
            [['created_at'], 'safe'],
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
        $query = UnsplashSearchPhotoRequest::find();

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
            'page' => $this->page,
            'count_result' => $this->count_result,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}
