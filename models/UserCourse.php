<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/27
 * Time: 15:01
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_course".
 *
 * @property integer $id
 * @property integer $course_id
 * @property integer $section_id
 * @property integer $version
 * @property integer $user_id
 * @property string $create_time
 * @property string $expire_time
 * @property integer $started
 * @property string $created
 *
 * @property Course $course
 * @property User $user
 */
class UserCourse extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'section_id', 'user_id','term_id'], 'required'],
            [['course_id', 'section_id', 'version','term_id', 'user_id', 'started'], 'integer'],
            [['create_time', 'expire_time', 'created'], 'safe'],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'course_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'course_id' => '课程id',
            'section_id' => '课程阶段id',
            'version' => '版本',
            'user_id' => '用户id',
            'create_time' => '课程开始时间',
            'expire_time' => '有效时间',
            'started' => '1否2shi:上课(审核就开课)',
            'created' => '创建时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['course_id' => 'course_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::className(), ['section_id' => 'section_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerm()
    {
        return $this->hasOne(TermModel::className(), ['id' => 'term_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    /**
     * ordercontroller.php
     * 添加用户与课程的关系
     **/
    public function add($param)
    {

        $this->course_id = $param['course_id'];
        $this->section_id = $param['section_id'];
        $this->version = $param['version'];
        $this->term_id = $param['term_id'];
        $this->started = $param['started'];
        $this->user_id = $param['user_id'];
        $this->create_time = $param['create_time'];
        $this->expire_time = $param['expire_time'];

        $id = self::save() ? Yii::$app->db->lastInsertID : '';
        return $id;
    }

    /**
     * 后台给用户批量添加课程关联
     **/
    public function modify(self $usercourse, $params)
    {
        foreach ($params as $param) {
            $usercourse = new UserCourse();
            $usercourse->course_id = $param['course_id'];
            $usercourse->section_id = $param['section_id'];
            $usercourse->version = $param['version'];
            $usercourse->term_id = $param['term_id'];
            $usercourse->started = $param['started'];
            $usercourse->user_id = $param['user_id'];
            $usercourse->create_time = $param['create_time'];
            $usercourse->expire_time = $param['expire_time'];
            $usercourse->save();
        }
        return true;
    }
}