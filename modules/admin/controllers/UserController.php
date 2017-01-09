<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/27
 * Time: 18:06
 */

namespace app\modules\admin\controllers;

use app\models\Course;
use app\models\search\UserCourseSearch;
use app\models\search\UserSearch;
use app\models\Section;
use app\models\TemplateCode;
use app\models\TermModel;
use app\models\Tool;
use app\models\User;
use app\models\UserCourse;
use app\models\Order;
use Yii;
use yii\web\Controller;
use app\models\Template;
use yii\data\Pagination;
use moonland\phpexcel\Excel;


class UserController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionList()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list',
            [
                'searchModel' => $searchModel,
                'userdate' => $dataProvider,
            ]);
    }

    public function actionDelete()
    {
        $id = Yii::$app->request->get('user_id');
        if ($id) {
            if (User::deleteAll(['user_id' => $id])) {
                return $this->redirect('list');
            }
        }
    }

    /**
     * 用户编辑
     * @param str user_id
     * @return array
     * @access public
     */
    public function actionEdit()
    {

        $user_id = Yii::$app->request->get('user_id');
        $user = User::findOne($user_id);
        if ($user->load(Yii::$app->request->post())) {
            $user->password = User::GenPassword($user->password);
            if ($user->save()) {
                Tool::notice('修改成功','notice');
                return $this->redirect('list');
            }
        }

        return $this->render('edit', [
            'user' => $user,
        ]);
    }

    /**
     * 用户列表搜索
     * @param
     * @return array
     * @access public
     */
    public function actionUserSearch()
    {
        $phone = Yii::$app->request->post('phone');
        if ($phone) {
            $user = User::findOne(['phone' => $phone])->attributes;
            $users = array($user);
        }
        $pagination = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => 1,
        ]);

        return $this->render('list', [
            'users' => $users,
            'pagination' => $pagination,
        ]);
    }

    public function actionCourseList(){

        $searchModel = new UserCourseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //print_r($dataProvider);
        //die;
        return $this->render('course_list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * 查看用户课程列表
     * @param string 密码
     * @return str 返回加密的用户密码
     * @access public
     */
    public function actionCourseList_old()
    {
        $course = Course::getCourse();
        $user_course = User::getUserCourse();
        //print_r( $user_course);die;
        return $this->render('course_list',
            ['user_course' => $user_course,
                'course' => $course]);

    }

    /**
     * 会员课程列表search
     * @param
     * @return array
     * @access public
     */
    public function actionSearch()
    {
        $course = Course::getCourse();
        $course_id = Yii::$app->request->post('course_id');
        $section_id = Yii::$app->request->post('section_id');
        $phone = Yii::$app->request->post('phone');
        $started = Yii::$app->request->post('started');
        if (!empty($course_id) && !empty($section_id)) {
            $where = " where uc.course_id = '{$course_id}' and uc.section_id = '{$section_id}'";
        }
        if (!empty($phone)) {
            $where = $where ? ' and ' : ' where ';
            $where .= " u.phone = '{$phone}'";
        }
        if (!empty($started)) {
            $where = $where ? ' and ' : ' where ';
            $where .= " uc.started = '{$started}'";
        }
        $user_course = User::getUserCourse($where);
        //print_r($user_course);die;
        return $this->render('course_list',
            ['user_course' => $user_course,
                'course' => $course,
                'course_id' => $course_id,
                'section_id' => $section_id,
                'phone' => $phone,
                'started' => $started,
            ]);
    }

    /**
     * 后台审核用户课程关联表（审核通过，开始上课）
     * @param string id user_course(id)
     * @return boolean
     * @access public
     */
    public function actionDelAll($id)
    {
        //$id = implode(',', Yii::$app->request->post('id'));
        //var_dump($user_course_ids);die;  string(5) "1,2,3"
        if ($id) {
            //print_r($create_time);die;
            $result = UserCourse::deleteAll("id in($id)");
            if ($result) {
                Tool::notice("$id 删除成功！",'notice');
                return $this->redirect('course-list');
            }
        }
    }

    /**
     * 删除会员课程关联关系
     * @param string id user_course(id)
     * @return boolean
     * @access public
     */
    public function actionCourseDel()
    {
        $id = Yii::$app->request->get('id');
        if ($id) {
            if (UserCourse::deleteAll(['id' => $id])) {
                $this->redirect('course-list');
            }
        }
    }


    /**
     * 会员课程列表修改
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionCourseUpdate($id)
    {
        $id = (int)$id;
        $courseModel = UserCourse::findOne($id);
        $userInfo = User::findOne($courseModel->user_id);
        $sectionInfo = Section::findOne($courseModel->section_id);
        $courseInfo = Course::findOne($courseModel->course_id);
        $termInfo = TermModel::findOne($courseModel->term_id);
        if ($courseModel) {
            //echo 'pre';
            //print_r(Yii::$app->request->post());die;
            if ($courseModel->load(Yii::$app->request->post())) {
                if ($courseModel->save()) {
                    return $this->redirect(['course-list']);
                } else {
                    return $this->render('course_update', [
                        'model' => $courseModel,
                    ]);
                }
            }
        }

        return $this->render('course_update', [
            'model' => $courseModel,
            'userInfo' => $userInfo,
            'termInfo' => $termInfo,
            'sectionInfo' => $sectionInfo,
            'courseInfo' => $courseInfo,

        ]);

    }

    /**
     * 会员课程关联修改
     * @param string id user_course(id)
     * @return boolean
     * @access public

    public function actionCourseEdit()
    {

        return $this->render('course_edit');
    }*/


    /**
     * 会员关联数据的导入
     * @param string id user_course(id)
     * @return boolean
     * @access public
     */
    public function actionCourseImport()
    {
        if (Yii::$app->request->post()) {

            if (isset($_FILES['user_course']['tmp_name'])
                && $_FILES['user_course']['tmp_name']
            ) {
                //$path_parts = pathinfo($param['user_course']['name']);
                $file = 'uploadFile.xlsx'; //可以定义一个上传后的文件名称uploadFile.xlsx
                $filename = '/uploads/user_course/' . $file;
                $filePath = Yii::getAlias('@webroot' . $filename);
                copy(
                    $_FILES['user_course']['tmp_name'],
                    $filePath
                );
                $data = Excel::import($filePath, [
                    'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel.
                    'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric.
                    'getOnlySheet' => 'Sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
                ]);

                $key = array('tid', 'receiver_name', 'receiver_state', 'receiver_city', 'receiver_district',
                    'receiver_address', 'receiver_mobile', 'outer_item_id', 'title','created');
                $section = array();
                //print_r($data);die;
                foreach ($data as $k=>$value){
                    $sections[$k] = array_combine($key, $value);
                }

                foreach ($sections as $v=> $val){
                    $sections[$v]['orders'][0]['outer_item_id'] = $val['outer_item_id'];
                    $sections[$v]['orders'][0]['title'] = $val['title'];
                }
                //print_r($sections);die;
                foreach ($sections as $order){
                    $ordernew = new Order();
                    $ordernew->AddOrderBug($order);
                }

            }
        }
        return $this->render('course_import');
    }
    /**
     * 会员关联数据的导入
     * @param string id user_course(id)
     * @return boolean
     * @access public
     */
    public function actionImportEdit()
    {
        if (Yii::$app->request->post()) {

            if (isset($_FILES['import_edit']['tmp_name'])
                && $_FILES['import_edit']['tmp_name']
            ) {
                //$path_parts = pathinfo($param['user_course']['name']);
                $file = 'uploadFile.xlsx'; //可以定义一个上传后的文件名称uploadFile.xlsx
                $filename = '/uploads/user_course/' . $file;
                $filePath = Yii::getAlias('@webroot' . $filename);
                copy(
                    $_FILES['import_edit']['tmp_name'],
                    $filePath
                );
                $data = Excel::import($filePath, [
                    'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel.
                    'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric.
                    'getOnlySheet' => 'Sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
                ]);

                $key = array('phone', 'id','expire_time');
                $section = array();
                $success= 0;
                $error = 0;
                //print_r($data);die;
                foreach ($data as $k=>$value){
                    $sections[$k] = array_combine($key, $value);
                }
                if(!$sections){
                    Tool::notice("没有任何数据上传",'error');
                    return $this->redirect('course_list');
                }
                //print_r($sections);die;
                foreach ($sections as $value){
                    if(empty($value['phone']) || empty($value['id']) || !isset($value['expire_time'])) continue;
                    $user = User::findOne(['phone'=>$value['phone']]);
                    $term = TermModel::findOne($value['id']);
                    if(!$user || !$term){
                        continue;
                    }
                    $user_course = UserCourse::findOne(['user_id'=>$user->user_id,'term_id'=>$term->id]);
                    if(!empty($user_course)) {
                        $end = date('Y-m-d H:i:s', $term->end_time);

                        $expire_time = date('Y-m-d H:i:s', strtotime("$end +6 month"));
                        $user_course->expire_time = isset($value['expire_time']) ? $value['expire_time'] : $expire_time;
                        if ($user_course->save()) {
                            $success++;
                        } else {
                            $error++;
                        }
                    }
                }
                Tool::notice("成功$success | $error",'success');
                return $this->redirect('course-list');
            }
        }
        return $this->render('course_edit');
    }
}