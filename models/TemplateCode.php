<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/17
 * Time: 19:14
 */


namespace app\models;
use Yii;
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

    public static function getTempCodeById($temp_code_id){
        $result = self::findOne($temp_code_id);

        //$sql = "SELECT t.type,t.template_id,c.code,c.temp_code_id FROM `template_code` AS c LEFT JOIN `template` AS t ON c.template_id = t.template_id WHERE c.temp_code_id='{$temp_code_id}'";
        //$result = Yii::$app->db->createCommand($sql)->query();
        //print_r($result);die;

        return $result;
    }

}