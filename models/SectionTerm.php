<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/11/17
 * Time: 15:09
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class SectionTerm extends Model
{
    public static function Add(self $sectionterm,$param){

        if(!$param){
            return false;
        }
        //$sectionterm = new SectionTerm();
        $sectionterm->term = $param['term'];
        $sectionterm->section_id = $param['section_id'];
        $sectionterm->expire_time = $param['expire_time'];
        $sectionterm->create_time = $param['create_time'];
        if ($sectionterm->save()) {
            return true;
        }
        return false;
    }

    public static function tableName()
    {
        return 'section_term';
    }

}