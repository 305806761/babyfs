<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/25
 * Time: 19:08
 */

namespace app\modules\admin\controllers;

use app\models\Course;
use app\models\CourseSection;
use app\models\SectionCat;
use app\models\Tool;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\models\Template;
use yii\web\UploadedFile;


class SectionController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * 课程列表
     */
    public function actionList()
    {

        $coursesection = CourseSection::getCourseSection();
        return $this->render('list', ['coursesection' => $coursesection]);

    }

    /**
     * 添加课程
     */
    public function actionAdd()
    {
        $course = Course::getCourse();
        $coursesection = new CourseSection();
        if (Yii::$app->request->post()) {
            $array = array(
                'name' => Yii::$app->request->post('name'),
                'code' => Yii::$app->request->post('code'),
                'course_id' => Yii::$app->request->post('course_id'),
                'section_id' => Yii::$app->request->post('section_id'),
                'expire_time' => Yii::$app->request->post('expire_time'),
                'sort' => Yii::$app->request->post('sort'),
               // 'image' => Yii::$app->request->post('image'),
            );
            $result = $coursesection->add($array);

            if ($result) {
                Tool::Redirect('/admin/section/list', '操作处理成功', 'success');
            }

        }

        return $this->render('add',
            ['course' => $course]);
    }

    public function actionListCat()
    {

        $cat = new SectionCat();
        $result = $cat->getList();
        // print_r($result);die;
        return $this->render('list_cat',
            ['list_cat' => $result]);
    }

    /**
     * 添加课程分组
     */
    public function actionAddCat()
    {
        $section_id = Yii::$app->request->post('section_id');
        $cat_name = Yii::$app->request->post('cat_name');
        $id = Yii::$app->request->post('id');
        if (Yii::$app->request->post()) {
            $array = array(
                'cat_name' => $cat_name,
                'section_id' => $section_id,
                'id' => $id,
            );
            $result = SectionCat::add($array);

            if ($result) {
                Tool::Redirect('/admin/section/list-cat', '操作处理成功', 'success');
            }
        }
        return $this->render('addcat', ['section_id' => Yii::$app->request->get('section_id')]);
    }

    public function actionEditCat()
    {
        $id = Yii::$app->request->get('id');
        $cat = SectionCat::find()->where(['id'=>$id])->asArray()->one();
        //print_r($cat);die;
        return $this->render('addcat', ['cat' => $cat]);
    }

    public function actionEditSection()
    {
        $course = Course::getCourse();
        $section_id = Yii::$app->request->get('section_id');
        $section = CourseSection::find()->where(['section_id'=>$section_id])->asArray()->one();
        //print_r($section);die;
        return $this->render('add', [
            'section' => $section,
            'course' => $course,
        ]);

    }


    public function actionGetSection()
    {
        $course_id = Yii::$app->request->get('course_id');
        if ($course_id) {
            $section = CourseSection::getById($course_id);
            //print_r($section);die;
            die(json_encode($section));
        }
    }

}