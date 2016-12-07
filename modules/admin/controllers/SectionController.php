<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/25
 * Time: 19:08
 */

namespace app\modules\admin\controllers;

use app\models\Course;
use app\models\search\TermSearchModel;
use app\models\search\CatSearch;
use app\models\Section;
use app\models\CourseSection;
use app\models\CourseWare;
use app\models\SectionCat;
use app\models\TermModel;
use app\models\Tool;
use app\models\User;
use app\models\UserCourse;
use app\models\Ware;
use Yii;
use yii\helpers\Html;
use yii\jui\Sortable;
use yii\web\Controller;


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
     * 添加课程阶段
     */
    public function actionAdd()
    {
        $course = Course::getCourse();
        $coursesection = new Section();
        if (Yii::$app->request->post()) {
            $array = array(
                'name' => Yii::$app->request->post('name'),
                'code' => Yii::$app->request->post('code'),
                'course_id' => Yii::$app->request->post('course_id'),
                'section_id' => Yii::$app->request->post('section_id'),
                'expire_time' => Yii::$app->request->post('expire_time'),
                'create_time' => Yii::$app->request->post('create_time'),
                'sort' => Yii::$app->request->post('sort'),
                'image' => $_FILES['image'],
                'buyurl' => Yii::$app->request->post('buyurl'),
            );
            //print_r($array);die;
            $result = $coursesection->add($array);
            if ($result) {
                Tool::Redirect('/admin/section/list', '操作处理成功', 'success');
            }
        }
        return $this->render('add',
            ['section' => $coursesection,
                'course' => $course,
            ]);
    }

    public function actionListCat()
    {
        $searchModel = new CatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //var_dump($dataProvider);die;
        return $this->render('list_cat', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 添加课程分组
     */
    public function actionAddCat()
    {
        $section_id = (int)Yii::$app->request->get('section_id');
        $term_id = (int)Yii::$app->request->get('term_id');
        $cat_name = Yii::$app->request->post('cat_name');
        $id = Yii::$app->request->post('id');

        if (Yii::$app->request->post() && (int)Yii::$app->request->post('section_id') && (int)Yii::$app->request->post('term_id')) {

            $array = array(
                'cat_name' => $cat_name,
                'section_id' => Yii::$app->request->post('section_id'),
                'term_id' => Yii::$app->request->post('term_id'),
                'image' => $_FILES['image'],
                'id' => $id,
            );

            $result = SectionCat::add($array);

            if ($result) {
                Tool::Redirect('/admin/section/list-cat/', '操作处理成功', 'success');
            }
        }
        return $this->render('addcat', ['section_id' => $section_id, 'term_id' => $term_id]);
    }


    public function actionEditCat()
    {
        $id = Yii::$app->request->get('id');
        $cat = SectionCat::find()->where(['id' => $id])->asArray()->one();
        //print_r($cat);die;
        return $this->render('addcat', ['cat' => $cat]);
    }

    /**
     * 删除分组
     */

    public function actionDeleteCat($id)
    {

        $model = SectionCat::findOne($id);
        if ($model->id) {
            $model->delete();
            return $this->redirect(['list-cat']);
        }

    }


    public function actionEditSection()
    {
        $course = Course::getCourse();
        $section_id = Yii::$app->request->get('section_id');
        $section = CourseSection::getCourseSection($section_id);

        //$section = Section::find()->where(['section_id' => $section_id])->asArray()->one();
        foreach ($course as $key => $value) {
            foreach ($section[course_id] as $val) {
                if ($value['course_id'] == $val['course_id']) {
                    $course[$key]['checked'] = 1;
                }
            }
        }
        //print_r($course);die;
        return $this->render('add', [
            'section' => $section,
            'course' => $course,
        ]);

    }

    /**
     * @添加学期
     * @return string
     */
    public function actionAddTerm()
    {
        $section_id = Yii::$app->request->get('section_id');
        if (!$section_id) {
            $this->redirect('list');
        }

        $section = Section::findOne($section_id);
        $termModel = new TermModel();

        //$termModel->load(Yii::$app->request->post());

        if ($termModel->load(Yii::$app->request->post())) {
            $termModel->section_id = $section_id;
            $termModel->start_time = strtotime($termModel->start_time);
            $termModel->end_time = strtotime($termModel->end_time);
            $termModel->order_start_time = strtotime($termModel->order_start_time);
            $termModel->order_end_time = strtotime($termModel->order_end_time);

            if ($termModel->save()) {
                $this->redirect('list-term');
            }
        }

        return $this->render('create', ['model' => $termModel, 'section' => $section]);
    }

    /*
     * @删除学期
     */
    public function actionDeleteTerm($id)
    {

        $model = TermModel::findOne($id);
        if ($model->id) {
            $model->delete();
            return $this->redirect(['list-term']);
        }

    }

    public function actionUpdateTerm($id)
    {
        $model = TermModel::findOne($id);

        $section = Section::findOne($model->section_id);

        if ($model->load(Yii::$app->request->post())) {

            $model->start_time = strtotime($model->start_time);
            $model->end_time = strtotime($model->end_time);
            $model->order_start_time = strtotime($model->order_start_time);
            $model->order_end_time = strtotime($model->order_end_time);

            if ($model->start_time < $model->end_time) {
                if ($model->save()) {
                    return $this->redirect(['list-term']);
                } else {
                    $model->start_time = date("Y-m-d", $model->start_time);
                    $model->end_time = date("Y-m-d", $model->end_time);
                    $model->order_start_time = date("Y-m-d", $model->order_start_time);
                    $model->order_end_time = date("Y-m-d", $model->order_end_time);
                    return $this->render('update-term', [
                        'model' => $model,
                        'section' => $section
                    ]);
                }
            } else {
                $model->start_time = date("Y-m-d", $model->start_time);
                $model->end_time = date("Y-m-d", $model->end_time);
                $model->order_start_time = date("Y-m-d", $model->order_start_time);
                $model->order_end_time = date("Y-m-d", $model->order_end_time);
                return $this->render('update-term', [
                    'model' => $model,
                    'section' => $section
                ]);
            }
        } else {
            $model->start_time = date("Y-m-d", $model->start_time);
            $model->end_time = date("Y-m-d", $model->end_time);
            $model->order_start_time = date("Y-m-d", $model->order_start_time);
            $model->order_end_time = date("Y-m-d", $model->order_end_time);
            return $this->render('update-term', [
                'model' => $model,
                'section' => $section
            ]);
        }

    }


    /**
     * @学期列表
     * @return string
     */
    public function actionListTerm()
    {

        $searchModel = new TermSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //print_r($dataProvider);
        //die;
        return $this->render('list_term', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }


    public function actionGetSection()
    {
        $course_id = Yii::$app->request->get('course_id');
        if ($course_id) {
            $section = CourseSection::getSectionByCourse_id($course_id);
            //print_r($section);die;
            die(json_encode($section));
        }
    }

    public function actionGetWare()
    {
        $section_cate_id = Yii::$app->request->get('section_cat_id');

        if (!$cate = SectionCat::findOne($section_cate_id)) {
            return $this->redirect(['/']);
        }

        if (Yii::$app->request->post()) {
            $sel_wares = Yii::$app->request->post('sel_ware');
            CourseWare::deleteAll(['section_cat_id' => $section_cate_id]);
            $used = [];
            $sort = 1;
            foreach ($sel_wares as $sel_ware) {
                if (!isset($used[$sel_ware])) {
                    $cw = new CourseWare();
                    $cw->section_cat_id = $section_cate_id;
                    $cw->version = 1;
                    $cw->ware_id = $sel_ware;
                    $cw->sort = $sort;
                    $cw->save();
                    $sort++;
                    $used[$sel_ware] = 1;
                }
            }
        }

        $selected_wares = [];
        if ($sel_wares = CourseWare::find()
            ->where(['section_cat_id' => $section_cate_id])
            ->orderBy(['sort' => SORT_ASC])
            ->all()
        ) {
            foreach ($sel_wares as $sel_ware) {
                $one = Ware::findOne($sel_ware->ware_id);
                $selected_wares[] = $this->renderPartial('ware', ['ware' => $one]);
            }
        }
        if (!$selected_wares) {
            $selected_wares[] = "&nbsp;";
        }

        $wares = [];
        if ($ware = Ware::find()->orderBy(['create_time' => SORT_DESC])->limit(20)->all()) {
            foreach ($ware as $one) {
                $wares[] = $this->renderPartial('ware', ['ware' => $one]);
            }
        }

        return $this->render('getware', ['cate' => $cate, 'selected_wares' => $selected_wares, 'wares' => $wares]);
    }

    public function actionSearch($keyword)
    {
        $wares = [];
        if ($keyword) {
            if ($ware = Ware::find()->where(['like', 'title', $keyword])->orWhere(['like', 'small_text', $keyword])->all()) {
                foreach ($ware as $w) {
                    $wares[] = $this->renderPartial('ware', ['ware' => $w]);
                }
            }
        } else {
            if ($ware = Ware::find()->orderBy(['create_time' => SORT_DESC])->limit(20)->all()) {
                foreach ($ware as $one) {
                    $wares[] = $this->renderPartial('ware', ['ware' => $one]);
                }
            }
        }
        return Sortable::widget([
            'items' => $wares,
            'options' => ['tag' => 'div'],
            'itemOptions' => ['tag' => 'div'],
            'clientOptions' => ['cursor' => 'move'],
            'id' => 'wares',
        ]);
    }

    /**
     * 添加用户与课程的关系
     * @param integer $section_id
     * @param integer $user_id
     * @param array $course_id
     * @return boolean
     */
    public function actionAddPermit()
    {
        $user_id = Yii::$app->request->get('user_id');
        if (!$user_id) {
            Tool::Redirect("/admin/user/list");
        }
        $user = User::findOne(['user_id' => $user_id]);
        $course_section = CourseSection::getCourse();
        if (Yii::$app->request->post()) {
            //Array ( [course_section_id] => Array ( [0] => 3,2 [1] => 4,2 ) [user_id] => 2 )
            $course_section_id = Yii::$app->request->post('course_section_id');
            $key = array('course_id', 'section_id');
            foreach ($course_section_id as $ke => $value) {
                $val = explode(',', $value);
                $sections[$ke] = array_combine($key, $val);
                $sections[$ke]['user_id'] = Yii::$app->request->post('user_id');
            }
            foreach ($sections as $k => $v) {
                //判断是阶段的那个学期
                $time = time();
                $term = TermModel::find()->where(
                    [
                        'AND', ['=', 'status', 2],
                        ['=', 'section_id', $v['section_id']],
                        ['>=', 'order_end_time', $time],
                        ['<=', 'order_start_time', $time],
                        //'order_end_time>:order_end_time' ,[':order_end_time' => strtotime($this->created)],
                    ]
                )->asArray()->one();
                $course = Course::findOne($v['course_id']);
                if($course->type == 3){
                    $term['start_time'] = $time;
                    $term['end_time'] = Yii::$app->params['course_expire'];
                }
                $sections[$k]['version'] = 1;
                $sections[$k]['started'] = 2;
                $sections[$k]['term_id'] = $term['id'];
                $sections[$k]['create_time'] = date('Y-m-d H:i:s', $term['start_time']);
                $sections[$k]['expire_time'] = date('Y-m-d H:i:s', $term['end_time']);
            }
            $usercourse = new UserCourse();
            $result = $usercourse->modify($usercourse, $sections);
            if ($result) {
                Tool::Redirect('/admin/user/course-list');
            } else {
                Tool::Redirect('/admin/user/list');
            }
        }
        //print_r($course_section);die;
        return $this->render('permit', [
            'course_section' => $course_section,
            'user' => $user,
        ]);
    }

}