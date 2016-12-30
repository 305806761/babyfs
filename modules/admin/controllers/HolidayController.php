<?php

namespace app\modules\admin\controllers;

use app\models\TermModel;
use Yii;
use app\models\Holiday;
use app\models\HolidaySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HolidayController implements the CRUD actions for Holiday model.
 */
class HolidayController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Holiday models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HolidaySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Holiday model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Holiday model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Holiday();

        $query = TermModel::find()
            ->joinWith(['sectionInfo' => function(){

            }])
            ->asArray()->all();
        $newArray = [];
        if ($query)
        {
            foreach ($query as $oneVal)
            {
                if ($oneVal['sectionInfo'])
                {
                    foreach ($oneVal['sectionInfo'] as $twoVal)
                    {
                        $newArray[$oneVal['id']] = $twoVal['name'].'（第'.$oneVal['term'].'学期）'.$oneVal['id'];
                    }
                }
            }

        }
        if (!empty($newArray))
        {

        } else {
            die('数据有误');
        }


        if ($model->load(Yii::$app->request->post())) {
            $model->start_time = strtotime($model->start_time);
            $model->end_time = strtotime($model->end_time);
            if ($model->end_time < $model->start_time) {
                die('结束时间必须大于开始时间');
            }

            $error = 0;
            if (!empty($model->term_id) && is_array($model->term_id)) {

                foreach ($model->term_id as $term)
                {
                    $isResult = Holiday::find()
                        ->where(['>=', 'end_time', $model->start_time])
                        ->andWhere(['like', 'term_id', ','.$term.','])
                        ->exists();
                    if ($isResult)
                    {
                        $error++;
                    }
                }
                $model->term_id = implode(',', $model->term_id);
                $model->term_id = ','.$model->term_id.',';
            } else {
                $model->term_id = '';
            }

            if ($error) {
                die('时间已经存在设置，请确认后添加');
            } else {
                if ($model->save())
                {
                    return $this->redirect(['index']);
                } else {
                    return $this->render('create', [
                        'model' => $model,
                        'arrayData' => $newArray,
                    ]);
                }
            }

        } else {
            return $this->render('create', [
                'model' => $model,
                'arrayData' => $newArray,
            ]);
        }

    }

    /**
     * Updates an existing Holiday model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $query = TermModel::find()
            ->joinWith(['sectionInfo' => function(){

            }])
            ->asArray()->all();
        $newArray = [];
        if ($query)
        {
            foreach ($query as $oneVal)
            {
                if ($oneVal['sectionInfo'])
                {
                    foreach ($oneVal['sectionInfo'] as $twoVal)
                    {
                        $newArray[$oneVal['id']] = $twoVal['name'].'（第'.$oneVal['term'].'学期）'.$oneVal['id'];
                    }
                }
            }

        }
        if (!empty($newArray))
        {

        } else {
            die('数据有误');
        }



        if ($model->load(Yii::$app->request->post())) {
            $model->start_time = strtotime($model->start_time);
            $model->end_time = strtotime($model->end_time);
            if ($model->end_time < $model->start_time) {
                die('结束时间必须大于开始时间');
            }
            $error = 0;
            if (!empty($model->term_id) && is_array($model->term_id)) {

                if ($model->day) {
                    //如果是以前的数据，就不判断了。虽然有问题，
                } else {
                    foreach ($model->term_id as $term)
                    {
                        $isResult = Holiday::find()
                            ->where(['>=', 'end_time', $model->start_time])
                            ->andWhere(['like', 'term_id', ','.$term.','])
                            ->andWhere(['<>', 'id', $id])
                            ->exists();

                        if ($isResult)
                        {
                            $error++;
                        }
                    }
                }

                if ($model->day) {
                    $model->term_id = $model->term_id[0];
                } else {
                    $model->term_id = implode(',', $model->term_id);
                    $model->term_id = ','.$model->term_id.',';
                }

            } else {
                $model->term_id = '';
            }

            if ($error) {
                die('时间已经存在设置，请确认后添加');
            } else {
                if ($model->save())
                {
                    return $this->redirect(['index']);
                } else {
                    if ($model->day) {
                        $options = [$model->term_id];
                    } else {
                        $options = explode(',', $model->term_id );
                        //去除第一个逗号和最后一个逗号
                        array_pop($options);
                        array_shift($options);
                    }

                    $model->term_id = $options;
                    return $this->render('update', [
                        'model' => $model,
                        'arrayData' => $newArray,
                    ]);
                }
            }

        } else {
            if ($model->term_id) {
                if ($model->day) {
                    $options = [$model->term_id];

                } else {
                    $options = explode(',', $model->term_id );
                    //去除第一个逗号和最后一个逗号
                    array_pop($options);
                    array_shift($options);
                }

                $model->term_id = $options;
                return $this->render('update', [
                    'model' => $model,
                    'arrayData' => $newArray,
                ]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'arrayData' => $newArray,
                ]);
            }

        }
    }

    /**
     * Deletes an existing Holiday model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Holiday model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Holiday the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Holiday::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
