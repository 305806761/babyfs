<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ware;

/**
 * WareSearch represents the model behind the search form about `app\models\Ware`.
 */
class WareSearch extends Ware
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ware_id'], 'integer'],
            [['title', 'small_text', 'contents', 'create_time'], 'safe'],
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
        $query = Ware::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ware_id' => $this->ware_id,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'small_text', $this->small_text])
            ->andFilterWhere(['like', 'contents', $this->contents]);

        return $dataProvider;
    }
}
