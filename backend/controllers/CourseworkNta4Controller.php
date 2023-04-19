<?php

namespace backend\controllers;

use Yii;
use common\models\CourseworkNta4;
use common\models\search\CourseworkNta4Search;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CourseworkNta4Controller implements the CRUD actions for CourseworkNta4 model.
 */
class CourseworkNta4Controller extends Controller
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
     * Lists all CourseworkNta4 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CourseworkNta4Search();
       // if (\common\models\UserAccount::userHas(['PR','HOD'])){
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        //}
//        else{
//            $dataProvider = new ActiveDataProvider(['query'=>CourseworkNta4::find()->where(['staff_id'=>Yii::$app->user->identity->user_id])]);
//            return $this->render('index', [
//                'searchModel' => $searchModel,
//                'dataProvider' => $dataProvider,
//            ]);
//        }
    }

    /**
     * Displays a single CourseworkNta4 model.
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
     * Creates a new CourseworkNta4 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CourseworkNta4();

        if ($model->load(Yii::$app->request->post())) {

            $results_exists=CourseworkNta4::find()->where(['academic_year_id'=>$model->academic_year_id,'course_id'=>$model->course_id,'semester_id'=>$model->semester_id])->exists();

            // if (!$results_exists){
            //     Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning"> The selected Coursework results are currently unavailable!</span>');
            //     return $this->render('create', ['model' => $model,]);
            // }

            $results=CourseworkNta4::find()->where(['academic_year_id'=>$model->academic_year_id,'course_id'=>$model->course_id,'semester_id'=>$model->semester_id])->groupBy(['student_id'])->all();
            $student_modules=CourseworkNta4::find()->where(['academic_year_id'=>$model->academic_year_id,'course_id'=>$model->course_id,'semester_id'=>$model->semester_id])->orderby(['created_at' => SORT_DESC])->groupBy(['module_id'])->all();



            return $this->render('result',[
                'model'=>$model,
                'results'=>$results,
                'student_modules'=>$student_modules,
            ]);


        }


        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CourseworkNta4 model.
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
     * Deletes an existing CourseworkNta4 model.
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
     * Finds the CourseworkNta4 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CourseworkNta4 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CourseworkNta4::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
