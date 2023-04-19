<?php

namespace backend\controllers;

use Yii;
use common\models\TimeTable;
use common\models\search\TimeTableSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * TimeTableController implements the CRUD actions for TimeTable model.
 */
class TimeTableController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','create','update','view','delete', 'findModel'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TimeTable models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TimeTableSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TimeTable model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TimeTable model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TimeTable();

        if ($model->load(Yii::$app->request->post())) {


            $time_table_exist=TimeTable::find()->where(['course_id'=>$model->course_id])->exists();
            if ($time_table_exist){

                Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning"> Time Table already exists! Please Update it Only</span>');
                return $this->redirect(['index']);
            }

            $model->created_by=Yii::$app->user->identity->getId();
            $model->time_table = Uploadedfile::getInstance($model, 'time_table');

            $model->save(false);
            
            
             $folderPath = "kcohas/backend/web/time_tables/";
            //$fileName=strtotime(date('Y-m-d H:i:s'));
            $file = $folderPath . $model->time_table->baseName. '.' . $model->time_table->extension;
            //file_put_contents($file, $model->time_table);
            
            $model->time_table->saveAs(Yii::getAlias('@web').'kcohas/backend/web/time_tables/' . $model->time_table->baseName. '.' . $model->time_table->extension);
            Yii::$app->session->setFlash('getSuccess','Uploaded Successfully!');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TimeTable model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

         //unlink(Yii::$app->basePath.'/web/time_tables/'. $model->time_table);
        if ($model->load(Yii::$app->request->post())) {

            $model->time_table = Uploadedfile::getInstance($model, 'time_table');
            $model->save(false);
            $model->time_table->saveAs(Yii::getAlias('@web').'kcohas/backend/web/time_tables/' . $model->time_table->baseName. '.' . $model->time_table->extension);
            Yii::$app->session->setFlash('getSuccess','Updated Successfully!');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TimeTable model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TimeTable model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TimeTable the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TimeTable::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
