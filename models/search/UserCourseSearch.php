<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/12/1
 * Time: 11:23
 */

namespace app\models\search;

use Yii;
use yii\base\Model;
use app\models\UserCourse;
use app\models\Section;
use app\models\User;
use app\models\TermModel;
use yii\data\ActiveDataProvider;

class UserCourseSearch extends UserCourse
{
    /**
     * @inheritdoc
     */
    public $section_name;
    public $term;
    public $phone;
    public function rules()
    {
        return [
            [['section_name', 'term', 'phone','create_time','expire_time'], 'safe'],
        ];
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
        $query = UserCourse::find();
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
         //var_dump($dataProvider);die;
        $query->joinWith(['section' => function ($query) {
            $query->from(['s' => Section::tableName()]);}]);

        $query->joinWith(['term' => function ($query) {
            //$query->select('term')
            $query ->from(['t' => TermModel::tableName()]);}]);

        $query->joinWith(['user' => function ($query) {
            //$query->select('phone')
               $query ->from(['u' => User::tableName()]);}]);

        $query->andFilterWhere(['like', 's.name', $this->section_name])
            ->andFilterWhere(['like', 't.term', $this->term])
            ->andFilterWhere(['like', 'u.phone', $this->phone])
            ->andFilterWhere(['like', 'create_time', $this->create_time])
            ->andFilterWhere(['like', 'expire_time', $this->expire_time]);
        //print_r($query->asArray()->all());die;
        //print_r($query->createCommand()->getRawSql());die;
        return $dataProvider;
    }

}