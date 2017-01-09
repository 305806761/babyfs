<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2017/1/9
 * Time: 13:58
 */

namespace app\models\search;


use app\models\User;
use yii\data\ActiveDataProvider;

class UserSearch extends User
{
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['phone', 'password', 'username', 'email'], 'safe'],
        ];
    }

    public function Search($params){

        $query = User::find();
        $dataProvider =  new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'user_id' => $this->user_id,
            'password' => $this->password,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }

}