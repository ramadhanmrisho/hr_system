<?php

namespace backend\controllers;

use Yii;
use common\models\OLevelInformation;
use common\models\search\OLevelInformationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * OLevelInformationController implements the CRUD actions for OLevelInformation model.
 */
class OLevelInformationController extends Controller
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
     * Lists all OLevelInformation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OLevelInformationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OLevelInformation model.
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
     * Creates a new OLevelInformation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OLevelInformation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing OLevelInformation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($student_id)
    {
        $id=OLevelInformation::find()->where(['student_id'=>$student_id])->one()->id;
        $model = $this->findModel($id);
        $model->o_level_certificate = UploadedFile::getInstance($model, 'o_level_certificate');

        if ($model->load(Yii::$app->request->post()) ) {
           // $model->o_level_certificate = UploadedFile::getInstance($model, 'o_level_certificate');
            if (!empty($model->o_level_certificate)) {
                // $filename = $model->student->fname . '-' . $model->student->lname . '-' . date('YmdHis') . '.' . $model->o_level_certificate->extension;
                $model->o_level_certificate->saveAs('attachments/' . $model->o_level_certificate->baseName . '.' . $model->o_level_certificate->extension);
            }

            if (empty($model->o_level_certificate)){
                $model->o_level_certificate = $model->getOldAttribute('o_level_certificate');
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
     * Deletes an existing OLevelInformation model.
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
     * Finds the OLevelInformation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OLevelInformation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OLevelInformation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
