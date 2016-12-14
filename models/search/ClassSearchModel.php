<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/14
 * Time: 下午4:50
 */

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\ClassModel;

class ClassSearchModel extends ClassModel
{

    public function rules()
    {

        return [
            [['name'], 'safe'],
        ];
    }

    public function search($params){
        $query = ClassModel::find()
            ->from(['c' => self::tableName()]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'lower(c.name)', strtolower($this->code)]);

        //$query->andFilterWhere(['like', 'DATE_FORMAT(FROM_UNIXTIME(order_add_time),\'%Y-%m-%d %H:%i:%s\')', strtolower($this->order_add_time)]);
        //print_r($query->createCommand()->getRawSql());
        //echo "<pre>";
        //print_r($query->asArray()->all());

        return $dataProvider;
    }

}