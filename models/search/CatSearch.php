<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/11/28
 * Time: 14:02
 */

namespace app\models\search;

use app\models\TermModel;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Section;
use app\models\SectionCat;

class CatSearch extends SectionCat
{
    /**
     * @inheritdoc
     */
    public $section_name;
    public $term;
    public $cat_name;
    public function rules()
    {
        return [
            [['section_name', 'term', 'cat_name'], 'safe'],
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
        $query = SectionCat::find();
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
        $query->joinWith(['section' => function ($query) {
           $query->from(['section' => Section::tableName()]);}]);

        $query->joinWith(['section_term' => function ($query) {
            $query->from(['section_term' => TermModel::tableName()]);}]);

        $query->andFilterWhere(['like', 'section.name', $this->section_name])
            ->andFilterWhere(['like', 'section_term.term', $this->term])
          ->andFilterWhere(['like', 'cat_name', $this->cat_name]);
           // ->andFilterWhere(['like', 'contents', $this->contents]);
        return $dataProvider;
    }

}