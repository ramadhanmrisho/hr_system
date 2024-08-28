<?php

namespace backend\controllers;

use common\models\search\PayrollTransactionsSearch;
use Yii;
use common\models\StaffSessions;
use common\models\search\StaffSessionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StaffSessionsController implements the CRUD actions for StaffSessions model.
 */
class StaffSessionsController extends Controller
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
     * Lists all StaffSessions models.
     * @return mixed
     */

    /**
     * Displays a single StaffSessions model.
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
     * Creates a new StaffSessions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new StaffSessions();
//        if ($model->load(Yii::$app->request->post())) {
//            $year = $model->year;
//            $month = $model ->month;
//            $searchModel = new PayrollTransactionsSearch();
//            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//            $dataProvider->query->andFilterWhere(['MONTH(created_at)' => $model->month])
//                ->andWhere(['YEAR(created_at)' => $model->year]);
//            return $this->render('index', [
//                'searchModel' => $searchModel,
//                'year'=> $year,
//                'month'=>$month,
//                'dataProvider' => $dataProvider,
//            ]);
//        }
//
//        return $this->render('create', ['model' => $model,]);
//    }


    public function actionCreate()
    {
        $model = new StaffSessions();

        if ($model->load(Yii::$app->request->post())) {
            $year = $model->year;
            $month = $model->month;

            // Set the year and month as query parameters for the redirect
            return $this->redirect(['index', 'year' => $year, 'month' => $month]);
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionIndex()
    {
        $searchModel = new PayrollTransactionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Filter by the year and month from the query parameters
        if ($year = Yii::$app->request->get('year')) {
            $dataProvider->query->andFilterWhere(['YEAR(created_at)' => $year]);
        }

        if ($month = Yii::$app->request->get('month')) {
            $dataProvider->query->andFilterWhere(['MONTH(created_at)' => $month]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'year' => $year,
            'month' => $month,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionPayroll()
    {
        $model = new StaffSessions();

        if ($model->load(Yii::$app->request->post())) {
            $year = $model->year;
            $month = $model->month;

            // Set the year and month as query parameters for the redirect
            return $this->redirect(['index1', 'year' => $year, 'month' => $month]);
        }
        return $this->render('payroll_total', ['model' => $model]);
    }


    public function actionIndex1()
    {
        $searchModel = new PayrollTransactionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Filter by the year and month from the query parameters
        if ($year = Yii::$app->request->get('year')) {
            $dataProvider->query->andFilterWhere(['YEAR(created_at)' => $year]);
        }

        if ($month = Yii::$app->request->get('month')) {
            $dataProvider->query->andFilterWhere(['MONTH(created_at)' => $month]);
        }

        return $this->render('index1', [
            'searchModel' => $searchModel,
            'year' => $year,
            'month' => $month,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionBank()
    {
        $model = new StaffSessions();
        if ($model->load(Yii::$app->request->post())) {
            $year = $model->year;
            $month = $model->month;
            $bankType = $model->account_name;

            // Set the year and month as query parameters for the redirect
            return $this->redirect(['index2', 'year' => $year, 'month' => $month,'bank'=>$bankType]);
        }
        return $this->render('bank_sheet', ['model' => $model]);
    }


    public function actionIndex2()
    {
        $searchModel = new PayrollTransactionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Filter by the year and month from the query parameters
        if ($year = Yii::$app->request->get('year')) {
            $dataProvider->query->andFilterWhere(['YEAR(payroll_transactions.created_at)' => $year]);
        }

        if ($month = Yii::$app->request->get('month')) {
            $dataProvider->query->andFilterWhere(['MONTH(payroll_transactions.created_at)' => $month]);
        }

        if ($bankType = Yii::$app->request->get('bank')) {
            $dataProvider->query->andFilterWhere(['staff.account_name' => $bankType])->join('INNER JOIN','staff','staff.id = payroll_transactions.staff_id');
        }

        return $this->render('index2', [
            'searchModel' => $searchModel,
            'year' => $year,
            'month' => $month,
            'bankType' => $bankType,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionNssf()
    {
        $model = new StaffSessions();
        if ($model->load(Yii::$app->request->post())) {
            $year = $model->year;
            $month = $model->month;

            // Set the year and month as query parameters for the redirect
            return $this->redirect(['index3', 'year' => $year, 'month' => $month]);
        }
        return $this->render('nssf_create', ['model' => $model]);
    }


    public function actionIndex3()
    {
        $searchModel = new PayrollTransactionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Filter by the year and month from the query parameters
        if ($year = Yii::$app->request->get('year')) {
            $dataProvider->query->andFilterWhere(['YEAR(created_at)' => $year]);
        }

        if ($month = Yii::$app->request->get('month')) {
            $dataProvider->query->andFilterWhere(['MONTH(created_at)' => $month]);
        }

        return $this->render('nssf', [
            'searchModel' => $searchModel,
            'year' => $year,
            'month' => $month,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionWcf()
    {
        $model = new StaffSessions();
        if ($model->load(Yii::$app->request->post())) {
            $year = $model->year;
            $month = $model->month;

            // Set the year and month as query parameters for the redirect
            return $this->redirect(['index4', 'year' => $year, 'month' => $month]);
        }
        return $this->render('wcf_create', ['model' => $model]);
    }


    public function actionIndex4()
    {
        $searchModel = new PayrollTransactionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Filter by the year and month from the query parameters
        if ($year = Yii::$app->request->get('year')) {
            $dataProvider->query->andFilterWhere(['YEAR(created_at)' => $year]);
        }

        if ($month = Yii::$app->request->get('month')) {
            $dataProvider->query->andFilterWhere(['MONTH(created_at)' => $month]);
        }

        return $this->render('wcf', [
            'searchModel' => $searchModel,
            'year' => $year,
            'month' => $month,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Updates an existing StaffSessions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing StaffSessions model.
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
     * Finds the StaffSessions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StaffSessions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StaffSessions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
