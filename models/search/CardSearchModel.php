<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/13
 * Time: 下午3:34
 */

namespace app\models\search;


use app\models\CardModel;
use app\models\ClassModel;
use app\models\Course;
use app\models\User;
use yii\data\ActiveDataProvider;

class CardSearchModel extends CardModel
{

    public $course_name;
    public $user_name;
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['code', 'password', 'course_name', 'user_name'], 'safe'],
            [['user_id', 'status', 'is_useable', 'is_active', 'is_used', 'is_cancel'], 'integer'],
        ];
    }

    public function search($params){
        $query = CardModel::find()
            ->from(['c' => self::tableName()]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $query->joinWith(['course' => function ($query) {
            $query->from(['s' => Course::tableName()]);
        }]);

        $query->joinWith(['users' => function ($query) {
            $query->from(['u' => User::tableName()]);
        }]);
        $sort = $dataProvider->getSort();

        $sort->attributes['course.name'] = [
            'asc' => ['s.name' => SORT_ASC],
            'desc' => ['s.name' => SORT_DESC],
            'label' => 'name',
        ];
        $sort->attributes['users.phone'] = [
            'asc' => ['u.phone' => SORT_ASC],
            'desc' => ['u.phone' => SORT_DESC],
            'label' => 'phone',
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'lower(c.code)', strtolower($this->code)]);
        $query->andFilterWhere(['like', 'lower(c.password)', strtolower($this->password)]);
        $query->andFilterWhere(['like', 'lower(s.name)', strtolower($this->course_name)]);
        $query->andFilterWhere(['like', 'lower(u.phone)', strtolower($this->user_name)]);

        //$query->andFilterWhere(['like', 'DATE_FORMAT(FROM_UNIXTIME(order_add_time),\'%Y-%m-%d %H:%i:%s\')', strtolower($this->order_add_time)]);
        //print_r($query->createCommand()->getRawSql());
        //echo "<pre>";
        //print_r($query->asArray()->all());
        if ($this->status) {
            $query->andFilterWhere(['c.status' => $this->status]);
        }
        if ($this->is_useable) {
            $query->andFilterWhere(['c.is_useable' => $this->is_useable]);
        }
        if ($this->is_active) {
            $query->andFilterWhere(['c.is_active' => $this->is_active]);
        }
        if ($this->is_used) {
            $query->andFilterWhere(['c.is_used' => $this->is_used]);
        }
        if ($this->is_cancel) {
            $query->andFilterWhere(['c.is_cancel' => $this->is_cancel]);
        }
//        print_r($query->createCommand()->getRawSql());
//        die;
        return $dataProvider;
    }

}