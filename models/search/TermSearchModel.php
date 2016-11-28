<?php

/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/11/18
 * Time: 下午3:22
 */
namespace app\models\search;


use app\models\TermModel;
use yii\data\ActiveDataProvider;
use app\models\base\BaseModel;

class TermSearchModel extends TermModel
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['term'], 'integer'],
            [['start_time', 'end_time', 'order_start_time', 'order_end_time'], 'safe'],
        ];
    }


    /**
     * @param  array $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {

        $query = TermModel::find()->where(['in', 'status', [self::STATUS_ACTIVE, self::STATUS_INACTIVE]]);

        $model = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $model;
        }

        $query->andFilterWhere(['like', 'DATE_FORMAT(FROM_UNIXTIME(start_time),\'%Y-%m-%d %H:%i:%s\')', strtolower($this->start_time)])
            ->andFilterWhere(['like', 'DATE_FORMAT(FROM_UNIXTIME(end_time),\'%Y-%m-%d %H:%i:%s\')', strtolower($this->end_time)])
            ->andFilterWhere(['like', 'DATE_FORMAT(FROM_UNIXTIME(order_start_time),\'%Y-%m-%d %H:%i:%s\')', strtolower($this->order_start_time)])
            ->andFilterWhere(['like', 'DATE_FORMAT(FROM_UNIXTIME(order_end_time),\'%Y-%m-%d %H:%i:%s\')', strtolower($this->order_end_time)])
            ->andFilterWhere(['like', 'lower(term)', strtolower($this->term)]);

//        if ($this->status) {
//            $query->andFilterWhere(['status' => $this->status]);
//        }



        return $model;


    }

}