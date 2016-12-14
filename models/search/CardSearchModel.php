<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/13
 * Time: 下午3:34
 */

namespace app\models\search;


use app\models\CardModel;
use yii\data\ActiveDataProvider;

class CardSearchModel extends CardModel
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['code', 'password'], 'safe'],
            [['user_id'], 'integer'],
        ];
    }

    public function search($params){
        $query = CardModel::find()
            ->from(['c' => self::tableName()]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'lower(c.code)', strtolower($this->code)]);
        $query->andFilterWhere(['like', 'lower(c.password)', strtolower($this->password)]);

        //$query->andFilterWhere(['like', 'DATE_FORMAT(FROM_UNIXTIME(order_add_time),\'%Y-%m-%d %H:%i:%s\')', strtolower($this->order_add_time)]);
        //print_r($query->createCommand()->getRawSql());
        //echo "<pre>";
        //print_r($query->asArray()->all());

        return $dataProvider;
    }

}