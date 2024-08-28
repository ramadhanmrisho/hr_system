<?php

namespace backend\controllers;

use common\models\ExamResult;
use common\models\Module;
use common\models\Semester;
use Yii;
use common\models\AcademicYear;
use common\models\search\AcademicYearSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AcademicYearController implements the CRUD actions for AcademicYear model.
 */
class AcademicYearController extends Controller
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
     * Lists all AcademicYear models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AcademicYearSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AcademicYear model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AcademicYear model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AcademicYear();

        $model->created_by = Yii::$app->user->identity->getId();
        if ($model->load(Yii::$app->request->post()) ) {

            $active_year=AcademicYear::find()->where(['status'=>'Active'])->one();
            if (!empty($active_year)){
                $active_year->status = 'Inactive';
                $active_year->save();
                $model->save();
                Yii::$app->session->setFlash('gSuccess',' <span class="fa fa-check-square"> Created Successfully!</span>');
                return $this->redirect(['index']);
            }
            else{
                Yii::$app->session->setFlash('getDanger',' <span class=" fa fa-close">  Financila Year '.$model->name. ' already exist!</span>');
                return $this->redirect(['index']);
            }


        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AcademicYear model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->status=='Active'){
                Yii::$app->session->setFlash('getDanger',' <span class=" fa fa-close"> Active Academic Year already exist!</span>');
                return $this->redirect(['index']);
            }

            $active_year=AcademicYear::find()->where(['status'=>'Active'])->exists();

            if ($model->status=='Inactive' && !$active_year){
                Yii::$app->session->setFlash('getDanger',' <span class=" fa fa-close"> There must be at least one Active Academic Year!</span>');
                return $this->redirect(['index']);
            }



            elseif($model->save()){
                Yii::$app->session->setFlash('gSuccess',' <span class="fa fa-check-square"> Updated Successfully!</span>');
                return $this->redirect(['index']);
            }

            else{
                Yii::$app->session->setFlash('getDanger',' <span class=" fa fa-close">  Academic Year '.$model->name. ' already exist!</span>');
                return $this->redirect(['index']);
            }

        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AcademicYear model.
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
     * Finds the AcademicYear model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AcademicYear the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AcademicYear::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
