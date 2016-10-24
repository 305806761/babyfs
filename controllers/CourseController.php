<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/8
 * Time: 12:41
 */

namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use app\models\Course;


class CourseController extends Controller
{
    public function actionIndex()
    {

        $query = Course::find();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $courses = $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        // print_r( $courses);die;

        return $this->render('index', [
            'course' => $courses,
            'pagination' => $pagination,
        ]);
    }

    public function actionAdd(){

               $course = Course::find()->indexBy('id')->all();

        }





}