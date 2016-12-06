<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/1
 * Time: 下午3:38
 */

namespace app\modules\admin\controllers;

use app\models\GroupModel;
use Yii;
use yii\web\Controller;
use moonland\phpexcel\Excel;

class GroupController extends Controller
{

    public function actionImport()
    {
        //$file = 'a.xlsx'; //可以定义一个上传后的文件名称uploadFile.xlsx
        //$filename = '/uploads/user_course/' . $file;
        //$filePath = Yii::getAlias('@webroot' . $filename);
        $filePath = Yii::getAlias('@uploads').'/a.xlsx';

        $data = Excel::import($filePath, [
            'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel.
            'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric.
            'getOnlySheet' => 'Sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
        ]);


        $key = array('name', 'code', 'wx_name', 'leader');

        $section = array();
        foreach ($data as $k=>$value){
            $sections[$k] = array_combine($key, $value);
        }
        $error = 0;
        $success = 0;
        foreach ($sections as $key=> $group){
            $groupModel = new GroupModel();
            $groupModel->name = $group['name'];
            $groupModel->wx_name = $group['wx_name'];
            $groupModel->code = $group['code'];
            $groupModel->leader = $group['leader'];
            $result = $groupModel->save();
            if($result){
                $success++;
            }else{
                print_r($groupModel->errors);
                $error++;
            }
        }
        echo '成功'.$success.'-------失败'.$error;

    }

}