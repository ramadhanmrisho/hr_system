<?php

namespace backend\controllers;

use common\models\UserAccount;
use Yii;
use common\models\SalaryAdjustments;
use common\models\search\SalaryAdjustmentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SalaryAdjustmentsController implements the CRUD actions for SalaryAdjustments model.
 */
class SalaryAdjustmentsController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all SalaryAdjustments models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SalaryAdjustmentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SalaryAdjustments model.
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
     * Creates a new SalaryAdjustments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SalaryAdjustments();

        if ($model->load(Yii::$app->request->post()) ) {
        foreach ($model->staff_ids as $staff){
            $staffModel=new SalaryAdjustments();
            $userID=UserAccount::findOne(['id' =>Yii::$app->user->identity->getId()])->user_id;
            $staffModel->staff_id=$staff;
            $staffModel->created_by=$userID;
            $staffModel->amount=(int)str_replace(',','',$model->amount);
            $staffModel->description=$model->description;
            $staffModel->save(false);
        }
            Yii::$app->session->setFlash('getSuccess',' <span class="fa fa-check-square-o">Added  Successfully</span>');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SalaryAdjustments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->amount=(int)str_replace(',','',$model->amount);
            if ($model->save(false)){
                Yii::$app->session->setFlash('getSuccess',' <span class="fa fa-check-square-o">Updated  Successfully</span>');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SalaryAdjustments model.
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
     * Finds the SalaryAdjustments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SalaryAdjustments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SalaryAdjustments::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
