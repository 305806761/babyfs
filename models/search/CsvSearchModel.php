<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/1
 * Time: 上午11:24
 */

namespace app\models\search;


use app\models\CsvModel;
use app\models\Course;
use yii\data\ActiveDataProvider;

class CsvSearchModel extends CsvModel
{


    public $course_name;
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['year', 'month', 'day'], 'integer'],
            [['title', 'subcategory_name', 'course_name', 'order_add_time', 'code', 'category_name'], 'safe'],

        ];
    }

    public function search($params)
    {
        $query = CsvModel::find()
            ->where(['c.status' => self::STATUS_ACTIVE])
            ->from(['c' => self::tableName()]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        $sort = $dataProvider->getSort();

        //$sort->defaultOrder = ['order_sort' => SORT_DESC];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->joinWith(['course' => function ($query) {
            $query->from(['course' => Course::tableName()]);
        }]);


        $query->andFilterWhere(['like', 'lower(c.title)', strtolower($this->title)]);
        $query->andFilterWhere(['like', 'lower(c.subcategory_name)', strtolower($this->subcategory_name)]);
        $query->andFilterWhere(['like', 'lower(c.category_name)', strtolower($this->category_name)]);
        $query->andFilterWhere(['like', 'lower(course.name)', strtolower($this->course_name)]);
        $query->andFilterWhere(['like', 'lower(c.code)', strtolower($this->code)]);

        $query->andFilterWhere(['like', 'DATE_FORMAT(FROM_UNIXTIME(order_add_time),\'%Y-%m-%d %H:%i:%s\')', strtolower($this->order_add_time)]);
        //print_r($query->createCommand()->getRawSql());
//        echo "<pre>";
//        print_r($query->asArray()->all());
        //echo "<pre>";
        //print_r($dataProvider);
        //die;
        return $dataProvider;
    }


}