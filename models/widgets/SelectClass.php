<?php

/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/16
 * Time: 下午4:12
 */
namespace app\models\widgets;

use app\models\CardModel;
use app\models\Course;
use yii\base\Widget;
use yii\base\InvalidConfigException;
use Yii;

class SelectClass extends Widget
{

    /**
     * @var string|array|Expression $condition the conditions that should be put in the WHERE part.
     */
    public $view = null;
    public $type = null;
    public $limit = 10;
    public $condition = null;
    public $className = null;
    public $form = null;
    public $columns = [ 'order_sort' => SORT_DESC ,'created_at' => SORT_DESC];
    public $model;


    public function init()
    {
        if ($this->view === null || $this->className === null) {
            throw new InvalidConfigException('The  property must be set.');
        }
    }

    /**
     * @return string
     */
    public function getViewPath()
    {
        //$appPath = Yii::getAlias('@app') . '/views/block';
        //return $appPath;
    }

    /**
     * @return string
     */
    public function run()
    {

        $model = new $this->className;

        if ( $this->type == '88' ) {
            $model = $this->model;
            $form = $this->form;
            $modelTableName = strtolower(substr($this->className, strrpos($this->className, '\\')+1));
//            $model->course_id = 1;
            return '
                <div class="row">
                        <div class="col-lg-5 " style="width:40%; margin-right: -87px;" >
                            '.$form->field($model, 'course_id', [
                                'template' => '
                                                    <label class="col-lg-5 control-label" >类型</label>
                                                    <div class="col-lg-5" >
                                                    {input}
                                                    {error}
                                                    </div>
                                        ',
                                ])->dropDownList(CardModel::getCourseList(0),[
                                    'prompt' => '--请选择课程--',
                                    'onchange' => '
                                                    $.post("'.Yii::$app->urlManager->createUrl('admin/card/courses').'", {"typeId":"1", "cateId":$(this).val()}, function(data){
                                                    $("select#'.$modelTableName.'-section_id").html(data);
                                                    $("select#'.$modelTableName.'-term_id option:not(:eq(0))").remove();
                    
                                    });',
                                ]).'
                        </div>
                        <div class="col-lg-2">
                            '.$form->field($model, 'section_id', [
                                    'template' => '
                                                    {input}
                                                    {error}
                                                                    ',
                                    ])->dropDownList(CardModel::getSectionList($model->section_id),[
                                        'prompt' => '--请选择阶段--',
                                        'onchange' => '
                                                        $.post("'.Yii::$app->urlManager->createUrl('admin/card/sections').'", {"typeId":"2", "cateId":$(this).val()}, function(data){
                                                        $("select#'.$modelTableName.'-term_id").html(data);
                                        });',

                                    ]).'
    
                        </div>

                        <div class="col-lg-2">
    
                            '.$form->field($model, 'term_id', [
                                    'template' => '
                                                    {input}
                                                    {error}
                                                        ',
                            ])->dropDownList(CardModel::getTermList($model->term_id),[
                                    'prompt' => '--请选择学期--',
                            ]).'
                        </div>
                
                </div>';

        }

        if ( $this->type == '1' ) {
            $query = Course::find()
                ->orderBy(['id' => SORT_DESC, 'created_at' => SORT_DESC]);

        }

        if (empty($query)) {
            $query = $model->find()
                ->where(['status' => '2'])
                ->limit($this->limit)
                ->orderBy($this->columns);
        }

        if ($this->condition) {
            $query->andWhere($this->condition);
        }
        $models = $query->asArray()->all();

        return $this->render($this->view, [
            'models' => $models,
        ]);
    }


}