<?php

namespace backend\controllers;

use common\models\ChangeNywila;
use common\models\PasswordForm;
use common\models\Staff;
use common\models\Student;
use Yii;
use common\models\UserAccount;
use common\models\search\UserAccountSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserAccountController implements the CRUD actions for UserAccount model.
 */
class UserAccountController extends Controller
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
     * Lists all UserAccount models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserAccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserAccount model.
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
     * Creates a new UserAccount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserAccount();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserAccount model.
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
     * Deletes an existing UserAccount model.
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
     * Finds the UserAccount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserAccount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserAccount::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



    /**
     * Change User password.
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionChangePassword()
    {
        $model = new PasswordForm();

        $modeluser = UserAccount::find()->where(['username'=>Yii::$app->user->identity->username])->one();

        if($model->load(Yii::$app->request->post()))
        {

            if($model->validate())
            {
                try
                {
                    $modeluser->password= Yii::$app->security->generatePasswordHash($_POST['PasswordForm']['newpass']);
                    $modeluser->save();
                    if($modeluser->save(false))
                    {

                        Yii::$app->session->setFlash('reqSuccess','Password changed Successfully');
                        return $this->redirect(['site/index']);
                    }
                    else
                    {

                        Yii::$app->getSession()->setFlash('reqDanger','Password not changed');

                        return $this->redirect(['user-account/change-password']);
                    }
                }
                catch(Exception $e)
                {
                    Yii::$app->getSession()->setFlash(
                        'error',"{$e->getMessage()}"
                    );
                    return $this->render('change-password',[
                        'model'=>$model
                    ]);
                }
            }
            else
            {
                return $this->render('change-password',[
                    'model'=>$model
                ]);
            }
        }
        else
        {
            return $this->render('change-password',[
                'model'=>$model
            ]);
        }
    }





    //**********CHANGE PASSWORD BY  ADMIN*************


    public function actionChangeNywila($id)
    {

        $model = new ChangeNywila();



        $user_account=UserAccount::find()->where(['id'=>$id])->one();

        $user_category=$user_account->category;

        if ($user_category=='staff'){
            $modeluser = Staff::find()->where(['id'=>$user_account->user_id])->one();
        }
        if ($user_category==''){
            $modeluser = Student::find()->where(['id'=>$user_account->user_id])->one();
        }


        if($model->load(Yii::$app->request->post()))
        {

            if($model->validate())
            {
                try
                {

                    $cmd=Yii::$app->db->createCommand()->update('user_account',['password'=>Yii::$app->security->generatePasswordHash($model->newpass)],['id'=>$id])->execute();

                    if($cmd)
                    {
                        Yii::$app->session->setFlash('getSuccess',' <span class="fa fa-check-square-o"> Password changed Successfully</span>');
                        return $this->redirect(['user-account/view','id'=>$id]);
                    }
                    else
                    {


                        Yii::$app->getSession()->setFlash('getDanger','Password not changed');
                        return $this->redirect(['user-account/view','id'=>$id]);
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



}
