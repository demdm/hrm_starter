<?php

namespace backend\modules\unsplashSearchPhoto\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UnsplashSearchPhotoSetting;

/**
 * UnsplashSearchPhotoSettingSearch represents the model behind the search form about `common\models\UnsplashSearchPhotoSetting`.
 */
class UnsplashSearchPhotoSettingSearch extends UnsplashSearchPhotoSetting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'social_network_account_id', 'per_page'], 'integer'],
            [['name', 'search', 'orientation', 'collections'], 'safe'],
            [['is_active', 'is_finished'], 'boolean'],
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
        $query = UnsplashSearchPhotoSetting::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere([
                'id' => $this->id,
                'social_network_account_id' => $this->social_network_account_id,
                'per_page' => $this->per_page,
                'is_active' => $this->is_active,
                'is_finished' => $this->is_finished,
            ])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'search', $this->search])
            ->andFilterWhere(['like', 'orientation', $this->orientation])
            ->andFilterWhere(['like', 'collections', $this->collections])
        ;

        return $dataProvider;
    }
}
