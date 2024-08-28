<?php

namespace backend\controllers;

use common\models\StaffLoans;
use common\models\search\StaffLoansSearch;
use common\models\UserAccount;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StaffLoansController implements the CRUD actions for StaffLoans model.
 */
class StaffLoansController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all StaffLoans models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new StaffLoansSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StaffLoans model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new StaffLoans model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new StaffLoans();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $model->loan_amount=(int)str_replace(',','',$model->loan_amount);
                $model->monthly_return=(int)str_replace(',','',$model->monthly_return);
                $userID=UserAccount::findOne(['id' =>Yii::$app->user->identity->getId()])->user_id;
                $model->created_by=$userID;
                if($model->monthly_return > $model->loan_amount ){
                    Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning">Monthly return must be less than the loan amount.</span>');
                    return $this->render('create', ['model' => $model,]);
                }
                elseif( $model->save()){
                    Yii::$app->session->setFlash(\dominus77\sweetalert2\Alert::TYPE_SUCCESS, [['confirmButtonText' => 'Ok']]);
                   // Yii::$app->session->setFlash('getSuccess','<span class="fa fa-check"> Loan Added Successfully.</span>');
                    return $this->redirect(['view', 'id' => $model->id]);

                }


            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing StaffLoans model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing StaffLoans model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the StaffLoans model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return StaffLoans the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StaffLoans::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
