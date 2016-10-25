<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/17
 * Time: 19:14
 */


namespace app\models;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class TemplateCode extends ActiveRecord
{
    public  function add($param){
        $this->template_id = $param['template_id'];
        $this->code = $param['code'];

        //  var_dump($user);die;
        //用户信息插入数据库
        $temp_code_id  = $this->save() ? Yii::$app->db->lastInsertID : '';
        return $temp_code_id;

    }

    public static function getTempCode(){
        $tempcode = self::find()->asArray()->all();
        return $tempcode;
    }

}