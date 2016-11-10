<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/27
 * Time: 18:06
 */

namespace app\modules\admin\controllers;

use app\models\Course;
use app\models\TemplateCode;
use app\models\Tool;
use app\models\User;
use app\models\UserCourse;
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
        $query = User::find();
        $pagination = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => $query->count(),
        ]);
        $users = $query->orderBy('phone')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        // print_r( $courses);die;

        return $this->render('list', [
            'users' => $users,
            'pagination' => $pagination,
        ]);
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
        if (!$user = User::findOne($user_id)) {
            return $this->redirect(['list']);
        }

        if (Yii::$app->request->post()) {
            if (User::modify($user, Yii::$app->request->post('phone'), Yii::$app->request->post('password'))) {
                return $this->redirect(['list']);
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

    /**
     * 查看用户课程列表
     * @param string 密码
     * @return str 返回加密的用户密码
     * @access public
     */
    public function actionCourseList()
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
    public function actionChecked()
    {
        $user_course_ids = implode(',', Yii::$app->request->post('id'));
        //var_dump($user_course_ids);die;  string(5) "1,2,3"
        if ($user_course_ids) {
            $create_time = date('Y-m-d H:i:s', time());
            //print_r($create_time);die;
            $sql = "update user_course set `started` = 2 ,`create_time` = '{$create_time}' where id in($user_course_ids)";
            $result = Yii::$app->db->createCommand($sql)->execute();
            if ($result) {
                Tool::Redirect("/admin/user/course-list");
            }
        }
    }

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
                    'getOnlySheet' => 'sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
                ]);
                var_dump($data);
                die;
            }
        }
        return $this->render('course_import');
    }
}