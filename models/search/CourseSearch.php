<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/12/2
 * Time: 11:00
 */

namespace app\models\search;


use app\models\Course;
use yii\data\ActiveDataProvider;

class CourseSearch extends Course
{
    public function rules()
    {
        return [
            [['course_id'], 'integer'],
            [['name', 'code',], 'safe'],
        ];
    }

    public function search($params){

        $query = Course::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'course_id' => $this->course_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }

}