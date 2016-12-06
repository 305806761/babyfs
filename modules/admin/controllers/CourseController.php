<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/20
 * Time: 9:28
 */
namespace app\modules\admin\controllers;

use app\models\Course;
use app\models\search\CourseSearch;
use app\models\Tool;
use Yii;
use yii\web\Controller;
use app\models\Template;


class CourseController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * 课程列表
     */
    public function actionList()
    {
        $searchModel = new CourseSearch(); //Yii::$app->request->queryParams
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list',
            [
                'searchModel' => $searchModel,
                'course' => $dataProvider,
            ]);

    }

    /**
     * 添加课程
     */
    public function actionAdd()
    {
        $model = new Course();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $this->redirect('list');
            }
        }

        return $this->render('add', ['model' => $model]);
    }

    /***
     * 修改课程
     ***/
    public function actionEdit($course_id)
    {
        $model = Course::findOne($course_id);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $this->redirect('list');
            }
        }
        return $this->render('update', ['model' => $model,]);

    }
    /*
     * @删除课程
     */
    public function actionDelete($course_id)
    {

        $model = Course::findOne($course_id);
        if ($model->course_id) {
            $model->delete();
            return $this->redirect(['list']);
        }

    }

}