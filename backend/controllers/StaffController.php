<?php

namespace backend\controllers;

use common\models\AttachmentsType;
use common\models\Dependants;
use common\models\Designation;
use common\models\District;
use common\models\EmployeeAttachments;
use common\models\EmployeeSpouse;
use common\models\NextOfKin;
use common\models\StaffAllowance;
use common\models\UserAccount;
use Yii;
use common\models\Staff;
use common\models\search\StaffSearch;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * StaffController implements the CRUD actions for Staff model.
 */
class StaffController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','create','update','view','delete', 'findModel','staff'],
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
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Staff models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StaffSearch();
        if (UserAccount::userHas(['HR','ACC','PR','ADMIN','HOD'])){
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);


        }
        else{

            $dataProvider=new ActiveDataProvider(['query'=>Staff::find()->where(['id'=>Yii::$app->user->identity->user_id])]);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Displays a single Staff model.
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
     * Creates a new Staff model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Staff();

        $userAccount_model=new UserAccount();
        
        if ($model->load(Yii::$app->request->post())) {




             $staff_number=Staff::find()->where(['employee_number'=>$model->employee_number])->exists();

            if ($staff_number){
                Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning">Employee Number already exists in the System!</span>');
                return $this->render('create', ['model' => $model,]);
            }

            $userID=UserAccount::findOne(['id' =>Yii::$app->user->identity->getId()])->user_id;
            $model->created_by=$userID;
            $model->salary_scale='TPS';

            $model->photo = Uploadedfile::getInstance($model, 'photo');
            $model->fname=strtoupper($model->fname);
            $model->mname=strtoupper($model->mname);
            $model->lname=strtoupper($model->lname);
            $model->basic_salary=(int)str_replace(',','',$model->basic_salary);
//            $model->nhif=(int)str_replace(',','',$model->nhif);
//            $model->paye=(int)str_replace(',','',$model->paye);
//            $model->helsb=(int)str_replace(',','',$model->helsb);
//            $model->nssf=(int)str_replace(',','',$model->nssf);


            //SAVING STAFF DETAILS

            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->save()) {
                    //CREATING USER ACCOUNT
                    $userAccount_model->user_id = $model->id;
                    $userAccount_model->username = $model->employee_number;
                    $userAccount_model->password = Yii::$app->security->generatePasswordHash($model->phone_number);
                    $userAccount_model->email = $model->email;
                    $userAccount_model->category = 'staff';
                    //$userAccount_model->designation_abbr=Designation::find()->where(['id'=>$model->designation_id])->one()->abbreviation;
                    $userAccount_model->created_by = Yii::$app->user->identity->getId();
                    $userAccount_model->save();
                    if (!empty($model->photo)) {
                        $model->photo->saveAs('staff_photo/' . $model->photo->baseName . '.' . $model->photo->extension);
                    }

                    //SAVING ALLOWANCE
                    if (!empty($model->allowance_id)) {
                        foreach ($model->allowance_id as $allowance) {
                            $alowance_model = new StaffAllowance();
                            $alowance_model->staff_id = $model->id;
                            $alowance_model->allowance_id = $allowance;
                            $alowance_model->created_by = Yii::$app->user->identity->getId();
                            $alowance_model->save();
                        }
                    }

                    //SAVING DEPENDANT INFO
                    if (!empty($model->dependant_information)) {
                        foreach ($model->dependant_information as $dependant) {
                            $dependant_model = new Dependants();
                            $dependant_model->name = $dependant['dependant_name'];
                            $dependant_model->staff_id = $model->id;
                            $dependant_model->gender = $dependant['dependant_gender'];
                            $dependant_model->dob = $dependant['date_of_birth'];
                            $dependant_model->save(false);
                        }
                    }
                    //SAVING NEXT OF KIN
                    $next_of_kin = new NextOfKin();
                    $next_of_kin->name = $model->next_of_kin_name;
                    $next_of_kin->relationship = $model->relationship;
                    $next_of_kin->staff_id = $model->id;
                    $next_of_kin->phone_number = $model->phone;
                    $next_of_kin->physical_address = $model->next_of_kin_address;
                    $next_of_kin->save(false);
                    //SPOUSE INFO
                    $spouse_model = new EmployeeSpouse();
                    $spouse_model->name = $model->spouse_name;
                    $spouse_model->phone_number = $model->spouse_phone_number;
                    $spouse_model->staff_id = $model->id;
                    $spouse_model->save(false);


                    //SAVING ATTACHMENTS
                    foreach (UploadedFile::getInstances($model,'attachments') as $key=>$val){
                        $attachment_model = new EmployeeAttachments();
                        $attachment_types_id=$_POST['Staff']['attachments'][$key]['attachments_type_id'];
                        $attachment_model->staff_id=$model->id;
                        $attachment_model->created_by=$userID;
                        $attachment_model->attachment_type_id=(int)$attachment_types_id;
                        $attachment_model->attached_file=$val->baseName.'.'.$val->extension;
                        $val->saveAs('employee_attachments/'.$val->baseName.'.'.$val->extension);
                        $attachment_model->save(false);
                    }
                    $transaction->commit();
                    Yii::$app->session->setFlash('getSuccess',' <span class="fa fa-check-square-o">Staff added Successfully!</span>');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            catch (\Exception $e){
             // Roll back the transaction
                $transaction->rollBack();
                var_dump($e);
                Yii::$app->session->setFlash('getDanger',$e->getMessage());
            }

var_dump($model->getErrors());
            die();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing Staff model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
   public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->created_by=Yii::$app->user->identity->getId();

        if ($model->load(Yii::$app->request->post())) {


            $model->photo = Uploadedfile::getInstance($model, 'photo');
            if (!empty($model->photo)) {
                $model->photo->saveAs('../web/staff_photo/' . $model->photo->baseName. '.' . $model->photo->extension);
            }

            if (empty($model->photo)){
                $model->photo = $model->getOldAttribute('photo');
            }

            if (!in_array("", $model->allowance_id, true)){
                foreach ($model->allowance_id as $allowance) {
                    $alowance_model = new StaffAllowance();
                    $alowance_model->staff_id = $model->id;
                    $alowance_model->allowance_id = $allowance;
                    $model->allowance_id = $allowance;
                    $userID=UserAccount::findOne(['id' =>Yii::$app->user->identity->getId()])->user_id;
                    $alowance_model->created_by = $userID;
                    $alowance_model->save(false);
                }
            }


            //SAVING DEPENDANT INFO
            if (!empty($model->dependant_information['0']['dependant_name'])) {
                foreach ($model->dependant_information as $dependant) {
                    $dependant_model = new Dependants();
                    $dependant_model->name = $dependant['dependant_name'];
                    $dependant_model->staff_id = $model->id;
                    $dependant_model->gender = $dependant['dependant_gender'];
                    $dependant_model->dob = $dependant['date_of_birth'];
                    $dependant_model->save(false);
                }
            }
            //SAVING NEXT OF KIN
            if(isset($model->next_of_kin_name)) {
                $next_of_kin = new NextOfKin();
                $next_of_kin->name = $model->next_of_kin_name;
                $next_of_kin->relationship = $model->relationship;
                $next_of_kin->staff_id = $model->id;
                $next_of_kin->phone_number = $model->phone;
                $next_of_kin->physical_address = $model->next_of_kin_address;
                $next_of_kin->save(false);
            }

            if (isset($model->spouse_name)) {
                //SPOUSE INFO
                $spouse_model = new EmployeeSpouse();
                $spouse_model->name = $model->spouse_name;
                $spouse_model->phone_number = $model->spouse_phone_number;
                $spouse_model->staff_id = $model->id;
                $spouse_model->save(false);
            }

          if ($model->save(false)){
               $user=UserAccount::findOne(['user_id' =>$model->id]);
              if ( $model->isAttributeChanged($model->employee_number))$user->username=$model->employee_number;
              if ($model->isAttributeChanged($model->phone_number))$user->password=Yii::$app->security->generatePasswordHash($model->phone_number);
              if ($model->isAttributeChanged($model->employee_number) || $model->isAttributeChanged($model->phone_number)){
                  $user->save(false);
              }
                //Yii::$app->db->createCommand()->update('user_account', ['username' =>$model->employee_number], ['user_id' =>$model->id])->execute();
                Yii::$app->session->setFlash('getSuccess','Staff Details Updated Successfully!');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Staff model.
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
     * Finds the Staff model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Staff the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Staff::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionListsdistrict($id)
    {
        $ids = preg_split('/,/', $id);
        $district = District::find()
            ->where(['IN','region_id',$ids])
            ->orderBy('name ASC')
            ->all();
        if (!empty($district)) {
            foreach($district as $dist) {
                echo "<option value =''> ----- Select District ----- </option>";
                echo "<option value='".$dist->id."'>".$dist->name."</option>";
            }
        }

    }


    public function actionUploadPhoto($id){
        $model = $this->findModel($id);
        $model->photo = UploadedFile::getInstance($model, 'photo');
        $model->created_by=Yii::$app->user->identity->getId();
        if( !is_null($model->photo) && file_exists('/'.$model->photo)){
            unlink('/'.$model->photo);
            $file = $this->upload($model);
            if($model->save() && $model->photo->saveAs($file))
            {
                return $this->redirect(['view', 'id' => $id]);
            }
            else
            {
                var_dump($model->getErrors());
                die();
            }
        }

        else{


            $model->photo = Uploadedfile::getInstance($model, 'photo');

            if (!empty($model->photo)){
                $saved=$model->photo->saveAs('staff_photo/' . $model->photo->baseName. '.' . $model->photo->extension);
            }

            if($model->save(false) && $saved)
            {
                return $this->redirect(['view', 'id' => $id]);
            }
            else
            {
                var_dump($model->getErrors());
                die();
            }
        }
    }


    private function upload($model){
        $fileName = $model->fname.'_'.$model->employee_number.'_' .Yii::$app->user->identity->id.'-' . date('Ymdhis');
        $model->photo = $fileName . '.' . $model->photo->extension;
        return $model->photo;
    }



    public function actionRemoveAllowance($id,$staff_id)
    {
        $model = StaffAllowance::find()->where(['staff_id' => $staff_id,'id'=>$id])->one();
        $model->delete();
        //Yii::$app->db->createCommand()->delete('staff_allowance', ['staff_id' => $staff_id,'id'=>$id])->execute();
        Yii::$app->session->setFlash('getSuccess','Allowance removed successfully!');
        return $this->redirect(['view', 'id' => $staff_id]);

    }
    

    //**********CHANGE PASSWORD BY  ADMIN*************


    public function actionChangeNywila($staff_id)
    {

        $model = new \common\models\ChangeNywila();

        $modeluser = Staff::find()->where(['id'=>$staff_id])->one();


        if($model->load(Yii::$app->request->post()))
        {

            if($model->validate())
            {
                try
                {
                    
                    $cmd=Yii::$app->db->createCommand()->update('user_account',['password'=>Yii::$app->security->generatePasswordHash($model->newpass)],['user_id'=>$staff_id])->execute();

                    if($cmd)
                    {

                        Yii::$app->session->setFlash('getSuccess',' <span class="fa fa-check-square-o"> Password changed Successfully</span>');
                        return $this->redirect(['staff/view','id'=>$staff_id]);
                    }
                    else
                    {

                        Yii::$app->getSession()->setFlash('getDanger','Password not changed');

                        return $this->redirect(['staff/view','id'=>$staff_id]);
                    }
                }
                catch(Exception $e)
                {
                    Yii::$app->getSession()->setFlash(
                        'error',"{$e->getMessage()}"
                    );
                    return $this->renderAjax('change-pwd',[
                        'model'=>$model
                    ]);
                }
            }
            else
            {


                return $this->renderAjax('change-pwd',[
                    'model'=>$model
                ]);
            }
        }
        else
        {

            return $this->renderAjax('change-pwd',[
                'model'=>$model
            ]);
        }
    }


    public function actionAddAttachment($id){


        $model = new EmployeeAttachments();
        $exclude =array_column(
            EmployeeAttachments::find()->where(['staff_id'=>$id])
                ->innerJoinWith('attachmentsType')
                ->select(['attachment_type_id'])
                ->asArray()
                ->all(),
            'attachment_type_id'
        );

        $attachment_types = AttachmentsType::find()
            ->where(['NOT IN','id',$exclude])
            ->all();


        if ($this->request->isPost && $model->load($this->request->post())) {


            $model->created_by=Yii::$app->user->getId();
            $model->staff_id=$id;
            $model->attached_file=UploadedFile::getInstance($model,'attached_file');
            $model->attached_file->saveAs('employee_attachments/'. $model->attached_file->baseName. '.' . $model->attached_file->extension);

            if ($model->save(false)){
                Yii::$app->session->setFlash('getSuccess',Yii::t('app',' <span class="fa fa-check"> Attachment added Successfully!'));
                return $this->redirect(['staff/view', 'id' => $id]);
            }

        }


        return $this->render('_addattachment', [
            'model' => $model,
            'attachment_types'=>$attachment_types
        ]);
    }

    //DELETE ATTACHMENT
    public function actionRemoveFile(){

        $model = EmployeeAttachments::findOne(Yii::$app->request->post('id'));
        $staff_id = $model->staff_id;
        if(file_exists($model->attached_file)){
            unlink($model->attached_file);
            $model->delete();
        }else{
            $model->delete();
        }
        Yii::$app->session->setFlash('getSuccess',Yii::t('app',' <span class="fa fa-check"> Attachment Removed Successfully!'));
        return $this->redirect(['view', 'id' => $staff_id]);

    }


    //RE ATTACHING

    public  function actionReattachFile($id){
        $model = EmployeeAttachments::findOne(['id'=>$id]);
        $staff_id = $model->staff_id;
        if ($this->request->isPost && $model->load($this->request->post())) {

            $model->attached_file=UploadedFile::getInstance($model,'attached_file');
            $model->attached_file->saveAs('employee_attachments/'. $model->attached_file->baseName. '.' . $model->attached_file->extension);

            if ($model->save(false)){
                // unlink($model->getOldAttribute('attachment')); BADO KU UNLINK OLD FILE
                Yii::$app->session->setFlash('getSuccess',Yii::t('app',' <span class="fa fa-check"> Attachment Edited Successfully!'));
                return $this->redirect(['view', 'id' => $staff_id]);
            }

        }
        return $this->render('_reattach', [
            'model' => $model,
        ]);

    }

    public function actionActivate($id){

        $model = $this->findModel($id);

        if(\Yii::$app->db->createCommand()->update('user_account',['status' => 10],['user_id' => $model->id])->execute()){
            Yii::$app->session->setFlash('reqSuccess','Account activated changed Successfully');

            return $this->redirect(['view', 'id' => $model->id]);
        }
    }
    public function actionDeactivate($id){

        $model = $this->findModel($id);

        if(\Yii::$app->db->createCommand()->update('user_account',['status' => 9],['user_id' => $model->id])->execute()){
            Yii::$app->session->setFlash('reqSuccess','Account deactivated changed Successfully');

            return $this->redirect(['view', 'id' => $model->id]);
        }
    }



}
