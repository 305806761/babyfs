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
    public function add($param)
    {
        $template_code = self::getTempCodeById($param['temp_code_id']);
        $template_code->template_id = $param['template_id'];
        $template_code->code = $param['code'];
        $result = Template::addType('', array('template_id' => $param['template_id'], 'param' => $param['param']));
        //  var_dump($user);die;
        //用户信息插入数据库
        if ($result) {
            if ($template_code->save()) {
                $temp_code_id = Yii::$app->db->lastInsertID ? Yii::$app->db->lastInsertID : $template_code->temp_code_id;
            }
        }

        return $temp_code_id ? $temp_code_id : false;

    }

    public static function getTempCodeById($temp_code_id)
    {

        if (!$temp_code_id) {
            $template_code = new TemplateCode();
        }
        if (!$template_code = self::findOne($temp_code_id)) {
            $template_code = new TemplateCode();
        }
        return $template_code;
    }

}