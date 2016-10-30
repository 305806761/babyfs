<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/30
 * Time: 15:56
 */

namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use app\models\CourseSection;


class SectionController extends Controller
{
    public function actionList()
    {
        $section_id = isset($_GET['section_id']) ? $_GET['section_id'] : '';
        //echo $_GET['section_id'];die;

        $cs = new CourseSection();
        $wares = $cs->getSectionWare($section_id);
        //print_r($wares);die;
        return $this->render('list', ['wares' => $wares]);
    }


}