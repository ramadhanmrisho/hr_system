<?php

namespace backend\controllers;

use common\models\Staff;
use common\models\UserAccount;
use Yii;
use common\models\Attendance;
use common\models\search\AttendanceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * AttendanceController implements the CRUD actions for Attendance model.
 */
class AttendanceController extends Controller
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
     * Lists all Attendance models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AttendanceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Attendance model.
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
     * Creates a new Attendance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Attendance();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $csv = UploadedFile::getInstance($model,'attached_file');
                if ($csv != null) {

                    $model->attached_file= UploadedFile::getInstance($model, 'attached_file');
                    $filename = 'attendances/' . date('Ymd-His') . '.' .$model->attached_file->extension;
                    if ($csv->saveAs($filename)) {
                        $file = fopen($filename, 'r+');
                        $line = 0;
                        $header = [];
                        $transaction = Yii::$app->db->beginTransaction();
                        try {

                            $previous_row = null;
                            while ($file && $row = fgetcsv($file)) {
                                //echo "Whiling"; exit();
                                $model2 = new Attendance();
                                $line++;
                                if ($line == 1) {
                                    $header = $row;
                                } else {
                                    $userID=UserAccount::findOne(['id' =>Yii::$app->user->identity->getId()])->user_id;
                                    $model2->staff_id=\common\helpers\ImportHelper::value2Id(Staff::className(), 'employee_number',$row[0]);
                                    $model2->date=$row[1];
                                    $model2->signin_at=date('Y-m-d H:i:s',strtotime($row[2]));
                                    $model2->singout_at=date('Y-m-d H:i:s',strtotime($row[3]));
                                    $model2->created_by=$userID;
                                    $dateTime1 = new \DateTime($model2->signin_at);
                                    $dateTime2 = new \DateTime($model2->singout_at);
                                    $interval = $dateTime1->diff($dateTime2);
                                    $model2->hours_per_day=$interval->h + ($interval->days * 24);
                                    $model2->save(false);
                                }
                            }
                            $transaction->commit();
                            unlink($filename);
                            Yii::$app->session->setFlash('getSuccess',' <span class="fa fa-check-square-o">Attendance Uploaded Successfully</span>');
                            return $this->redirect(['/attendance/index']);
                        }

                        catch (\Exception $e) {
                            //var_dump( $e->getMessage());die();
                            fclose($file);
                            unlink($filename);
                            $transaction->rollBack();
                            Yii::$app->session->setFlash('Error', $e->getMessage());
                            return $this->render('create', ['model' => $model,]);
                        }
                    }
                }else{

                    Yii::$app->session->setFlash('danger', 'No file attached');
                    return $this->redirect(['/shule/index']);
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
     * Updates an existing Attendance model.
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
     * Deletes an existing Attendance model.
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
     * Finds the Attendance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Attendance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Attendance::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
