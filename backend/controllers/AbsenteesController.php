<?php

namespace backend\controllers;

use common\models\UserAccount;
use Yii;
use common\models\Absentees;
use common\models\search\AbsenteesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AbsenteesController implements the CRUD actions for Absentees model.
 */
class AbsenteesController extends Controller
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
     * Lists all Absentees models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AbsenteesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Absentees model.
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
     * Creates a new Absentees model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Absentees();
        if ($model->load(Yii::$app->request->post())) {
            $userID=UserAccount::findOne(['id' =>Yii::$app->user->identity->getId()])->user_id;
            $model->created_by=$userID;
            if ($model->save(false)){
                Yii::$app->session->setFlash('getSuccess',' <span class="fa fa-check-square-o">Added  Successfully</span>');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Absentees model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $userID=UserAccount::findOne(['id' =>Yii::$app->user->identity->getId()])->user_id;
            $model->created_by=$userID;
           if ($model->save(false)){
               Yii::$app->session->setFlash('getSuccess',' <span class="fa fa-check-square-o">Added  Successfully</span>');
               return $this->redirect(['view', 'id' => $model->id]);
           }
            var_dump($model->getErrors());die();
        }


        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Absentees model.
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
     * Finds the Absentees model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Absentees the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Absentees::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
