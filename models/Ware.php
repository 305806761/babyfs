<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/20
 * Time: 11:26
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ware".
 *
 * @property integer $ware_id
 * @property string $title
 * @property string $small_text
 * @property string $contents
 * @property string $create_time
 *
 * @property CourseWare[] $courseWares
 */
class Ware extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ware';
    }

    /**
     * @inheritdoc  image	char(120)
     */
    public function rules()
    {
        return [
            [['title', 'small_text'], 'required'],
            [['create_time'], 'safe'],
            [['title'], 'string', 'max' => 150],
            [['small_text'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 120],
            [['contents'], 'string', 'max' => 2000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ware_id' => '课件ID',
            'title' => '课件名称',
            'small_text' => '课件简介',
            'image' => '课件首图',
            'contents' => '课件内容',
            'create_time' => '创建时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseWares()
    {
        return $this->hasMany(CourseWare::className(), ['ware_id' => 'ware_id']);
    }


    public static function saveAll(self $model)
    {

        if (!Yii::$app->request->post()) {
            return false;
        }

        if (!$model->load(Yii::$app->request->post()) || !$types = Yii::$app->request->post('WareType')) {
            return false;
        }

        $sections = [];
        foreach ($types as $type_id => $section) {
            if (substr($type_id, 0, 1) == 'n') {
                $wt = new WareType();
            } else {
                $wt = WareType::findOne($type_id);
            }
            if (!$wt) {
                continue;
            }

            if (!isset($section['template_id']) || !$template = Template::findOne($section['template_id'])) {
                continue;
            }

            $wt->template_id = $section['template_id'];
            if (!$template->param || !$p = json_decode($template->param, true)) {
                continue;
            }

            $c = [];
            foreach ($p as $name => $type) {
                if (isset($section[$name])) {
                    if ($type == 'text_array') {
                        $c[$name] = explode('|', $section[$name]);
                    } else {
                        $c[$name] = $section[$name];
                    }
                }
                if ($type == 'image') {
                    $file_control = $name . '_file';
                    if (isset($_FILES['WareType']['tmp_name'][$type_id][$file_control])
                        && $_FILES['WareType']['tmp_name'][$type_id][$file_control]
                    ) {
                        $path_parts = pathinfo($_FILES['WareType']['name'][$type_id][$file_control]);
                        $file = '/uploads/ware/' . time() . rand(100, 999) . '.' . $path_parts['extension'];
                        copy(
                            $_FILES['WareType']['tmp_name'][$type_id][$file_control],
                            Yii::getAlias('@webroot' . $file)
                        );
                        $c[$name] = $file;
                    }
                }
            }
            $wt->content = json_encode($c);

            if (isset($section['temp_code_id'])) {
                $wt->temp_code_id = $section['temp_code_id'];
            }
            if ($wt->save()) {
                $sections[] = $wt->type_id;
            }
        }

        if (!$sections) {
            return false;
        }

        if (isset($_FILES['Ware']['tmp_name']['image'])
            && $_FILES['Ware']['tmp_name']['image']
        ) {
            $path_parts = pathinfo($_FILES['Ware']['name']['image']);
            $file = '/uploads/ware/' . time() . rand(100, 999) . $path_parts['basename'];
            copy(
                $_FILES['Ware']['tmp_name']['image'],
                Yii::getAlias('@webroot' . $file)
            );
            $model->image = json_encode($file);
        }
        $model->contents = json_encode($sections);
        if (!$model->save()) {
            return false;
        }

        return true;
    }

    public static function getUsable($section_id,$term_id, $start_time)
    {
        if (!$section = Section::findOne($section_id)) {
            return false;
        }
        if ($start_time > time()) {
            return false;
        }
        if(!$term = TermModel::findOne(['section_id'=>$section_id,'id'=>$term_id])){
            return false;
        }

        $u = 0;
        for (; $start_time <= time(); $start_time += 86400) {

            if ($day = Holiday::findOne(['day' => date('Y-m-d', $start_time),'term_id'=> $term->id])) {
                if ($day->type == Holiday::TYPE_SCHOOL_DAY) {
                    $u++;
                }
                continue;
            }
            if (in_array(date('w', $start_time), [1, 3, 5])) {
                $u++;
            }
        }
        return $u;
    }
}