<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 11:43
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;

class OpController extends Controller
{
    public $layout = "newlayout";
    //public $layout = "header";
    public function actionIndex()
    {
        return $this->render('index');
    }

}