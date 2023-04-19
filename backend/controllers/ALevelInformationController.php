<?php

namespace backend\controllers;

use common\models\OLevelInformation;
use Yii;
use common\models\ALevelInformation;
use common\models\search\ALevelInformationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ALevelInformationController implements the CRUD actions for ALevelInformation model.
 */
class ALevelInformationController extends Controller
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
     * Lists all ALevelInformation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ALevelInformationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ALevelInformation model.
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
     * Creates a new ALevelInformation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ALevelInformation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ALevelInformation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($student_id)
    {
        $id=ALevelInformation::find()->where(['student_id'=>$student_id])->one()->id;
        $model = $this->findModel($id);
        $model->a_level_certificate = UploadedFile::getInstance($model, 'a_level_certificate');

        if ($model->load(Yii::$app->request->post()) ) {
            if (!empty($model->a_level_certificate)) {
                $model->a_level_certificate->saveAs('attachments/' . $model->a_level_certificate->baseName . '.' . $model->a_level_certificate->extension);
            }

            if (empty($model->a_level_certificate)){
                $model->a_level_certificate = $model->getOldAttribute('a_level_certificate');
            }
            if ($model->save()){
                Yii::$app->session->setFlash('getSuccess', ' <span class="fa fa-check-square-o"> Changes Saved Successfully !</span>');
                return $this->redirect(['student/view', 'id' => $student_id]);
            }

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ALevelInformation model.
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
     * Finds the ALevelInformation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ALevelInformation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ALevelInformation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
