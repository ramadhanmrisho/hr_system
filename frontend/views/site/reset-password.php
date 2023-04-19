<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title='New  Password ';


$this ->beginBody();

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];


?>
    <strong>

        <h1 align="center"  style="color:darkslateblue" > <b style=" font-family:Algerian" >Shop Management App</b></h1>
    </strong>

    <div class="login-box" style="height: 60px">
        <div class="login-logo">

        </div>
        <!-- /.login-logo -->
        <div class="login-box-body" style="height: 500px" >

            <div style="text-align: center">
                <img src="images/logo.png" width="180px">
            </div>

            <div class="login-box-msg" style="color:steelblue"><b style="font-family: 'Bell MT'">Change Password</b></div>
            <h4 style="font-family:'Bell  MT'" >Please Enter your New Password </h4>

            <div class="row">
                <div class="col-lg-12">
                    <div class="site-reset-password">

                        <div class="row">
                            <div class="col-lg-12">
                                <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                                <?= $form->field($model, 'password',$fieldOptions1)->passwordInput(['autofocus' => true]) ?>

                                <div class="form-group">
                                    <?= Html::submitButton('Save New Password', ['class' => 'btn btn-primary']) ?>
                                </div>

                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-8" align="left">



                </div>

            </div>

        </div>
        <!-- /.login-box-body -->
    </div><!-- /.login-box -->
<?php  $this->endBody() ?>