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
            //[['term'], 'integer'],
        ];
    }


    /**
     * @param  array $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search()
    {

        $query = TermModel::find()->where(['in', 'status', [self::STATUS_ACTIVE, self::STATUS_INACTIVE]]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //$sort = $dataProvider->getSort();
        //$sort->defaultOrder = ['order_sort' => SORT_DESC, 'created_at' => SORT_DESC];

        return $dataProvider;


        //$query->andFilterWhere(['like', 'lower(id)', $this->id]);
        //$query->andFilterWhere(['like', 'lower(year)', $this->year]);
        //$query->andFilterWhere(['like', 'lower(profit)', $this->profit]);
        //$query->andFilterWhere(['like', 'lower(dividend)', $this->dividend]);
        //$query->andFilterWhere(['like', 'lower(order_sort)', $this->order_sort]);
        //if ($this->status) {
        //    $query->andFilterWhere(['status' => $this->status]);
        //}



    }

}