<?php

namespace backend\modules\socialNetwork\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SocialNetworkAccount;

/**
 * SocialNetworkAccountSearch represents the model behind the search form about `common\models\SocialNetworkAccount`.
 */
class SocialNetworkAccountSearch extends SocialNetworkAccount
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'count_published', 'count_skipped'], 'integer'],
            [['is_active'], 'boolean'],
            [['name', 'comment', 'type', 'login', 'password', 'extra'], 'safe'],
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
        $query = SocialNetworkAccount::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['count_published' => $this->count_published])
            ->andFilterWhere(['count_skipped' => $this->count_published])
            ->andFilterWhere(['is_active' => $this->is_active])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'login', $this->login])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'extra', $this->extra])
        ;

        return $dataProvider;
    }
}
