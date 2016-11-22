<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Holiday;

/**
 * HolidaySearch represents the model behind the search form about `app\models\Holiday`.
 */
class HolidaySearch extends Holiday
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type','term_id'], 'integer'],
            [['day', 'ctime'], 'safe'],
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
        $query = Holiday::find();

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
            'id' => $this->id,
            'day' => $this->day,
            'term_id' => $this->term_id,
            'type' => $this->type,
            'ctime' => $this->ctime,
        ]);

        return $dataProvider;
    }
}
