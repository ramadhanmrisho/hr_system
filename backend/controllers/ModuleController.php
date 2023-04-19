<?php

namespace backend\controllers;

use common\models\AssessmentMethod;
use common\models\AssessmentMethodTracking;
use Yii;
use common\models\Module;
use common\models\search\ModuleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ModuleController implements the CRUD actions for Module model.
 */
class ModuleController extends Controller
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
     * Lists all Module models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ModuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Module model.
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
     * Creates a new Module model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Module();

        $model->created_by=Yii::$app->user->identity->getId();
       

        if ($model->load(Yii::$app->request->post())) {

           
            $module_exist=Module::find()->where(['module_code'=>$model->module_code])->exists();
            if (!$module_exist) {
                $methodi=0;
                foreach ($model->assessment_methods as $method):
                    if(empty($method['assessment_method_id'])||empty($method['category'])||empty($method['percent'])){
                        $methodi++;
                    }
                endforeach;

                if($methodi>0){
                    Yii::$app->session->setFlash('getDanger','<h5 class="font-weight-bold">Please! Fill Assessment Methods</h5>');
                    return $this->redirect(['create']);
                }
                if ($model->save()){
                     $model->year_of_study_id= Module::find()->where(['id'=>$model->id])->one()->year_of_study_id;
                    foreach ($model->assessment_methods as $method){
                        $methods=new AssessmentMethodTracking();
                        $methods->module_id=$model->id;
                        $methods->assessment_method_id=$method['assessment_method_id'];
                        $methods->category=$method['category'];
                        $methods->percent=$method['percent'];
                        $methods->save();
                    }
                    Yii::$app->session->setFlash('getSuccess', '<span class="fa fa-check-square"> Module Registered Successfully!</span>');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            else{
                Yii::$app->session->setFlash('getDanger', 'This Module is Exists! Please Review Info');
                return $this->render('create', [
                    'model' => $model,
                ]);
            }

        }


        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Module model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if( $model->save()){

                if (!empty($model->assessment_methods)){
                    foreach($model->assessment_methods as $method){
                        $methods=new AssessmentMethodTracking();
                        $methods->module_id=$model->id;
                        $methods->assessment_method_id=$method['assessment_method_id'];
                        $methods->category=$method['category'];
                        $methods->percent=$method['percent'];
                        $methods->save();
                    }
                }
                Yii::$app->session->setFlash('getSuccess','Module Details Updated Successfully!');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
    
    
        //REMOVE METHOD
    public function actionRemoveModule($id,$module_id)
    {
        $model = AssessmentMethodTracking::find()->where(['module_id' => $module_id,'id'=>$id])->one();
        $model->delete();
        //Yii::$app->db->createCommand()->delete('staff_allowance', ['staff_id' => $staff_id,'id'=>$id])->execute();
        Yii::$app->session->setFlash('getSuccess','Removed successfully!');
        return $this->redirect(['view', 'id' => $module_id]);

    }


    /**
     * Deletes an existing Module model.
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
     * Finds the Module model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Module the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Module::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionListmethod($id)
    {
        $ids = preg_split('/,/', $id);
        $methods = AssessmentMethod::find()
            ->where(['IN','nta_level',$ids])
            ->orderBy('name ASC')
            ->all();
        if (!empty($methods)) {
            foreach($methods as $dist) {
                echo "<option value =''> ----- Select Method ----- </option>";
                echo "<option value='".$dist->id."'>".$dist->name."</option>";
            }
        }

    }
}
