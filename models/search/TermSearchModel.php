<?php

/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/11/18
 * Time: 下午3:22
 */
namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TermModel;


class TermSearchModel extends TermModel
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'term'], 'integer'],
            [['start_time', 'end_time', 'order_start_time', 'order_end_time', 'status'], 'safe'],
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


    public function search($params)
    {

        $query = TermModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        /*foreach ($params as $key => $value) {

            $params[$key]['start_time'] = strtotime($value['start_time']);
            $params[$key]['end_time'] = strtotime($value['end_time']);
            $params[$key]['order_start_time'] = strtotime($value['order_start_time']);
            $params[$key]['order_end_time'] = strtotime($value['order_end_time']);

        }*/
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        //print_r($this);die;
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'order_start_time' => $this->order_start_time,
            'order_end_time' => $this->order_end_time,
            /*'start_time' => strtotime($this->start_time),
            'end_time' => strtotime($this->end_time),
            'order_start_time' => strtotime($this->order_start_time),
            'order_end_time' => strtotime($this->order_end_time),*/
        ]);

        $query->andFilterWhere(['like', 'term', $this->term]);
        // ->andFilterWhere(['like', 'end_time', $this->end_time])
        //  ->andFilterWhere(['like', 'order_start_time', $this->order_start_time])
        // ->andFilterWhere(['like', 'order_end_time', $this->order_end_time]);

        return $dataProvider;
    }

}