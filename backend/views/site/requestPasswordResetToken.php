<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;

$this->title='Request Password Reset';

$this ->beginBody();

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];


?>
    <strong>


    </strong>

    <div class="login-box" style="height: 60px;font-family: Lucida Bright" >
        <div class="login-logo">

        </div>
        <!-- /.login-logo -->
        <div class="panel panel-default fadeIn" style="border-bottom:5px solid dodgerblue; border-radius: 25px; padding:10px;">
            <div class="panel-body ">
                <div class="wrap-inner" style="border-top: 5px solid  dodgerblue;">
                    <div class="login-box-body"  style="height: 450px"  style="alignment:left">
        <div class="login-box-body" style="height: 450px" >

            <div style="text-align: center">
                <img src="images/pay.jpeg" width="100px"  height="100px" class="img-circle">
            </div>

            <div class="login-box-msg" style="color:steelblue"><b style="font-family: 'Bell MT'">Request Password Reset</b></div>
            <h4 style="font-family:'Bell  MT'" >Please fill out your email. A link to reset password will be sent there.</h4>

            <div class="row">
                <div class="col-lg-12">
                    <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>


                    <?= $form->field($model, 'email',['template'=>'{beginLabel}{labelTitle}{endLabel}<div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope" style="color:dodgerblue;"></i></span>{input}</div>{error}{hint}'])->textInput(['placeholder'=>'Email'])->label(false) ?>



                    <div class="form-group" align="right">
                        <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                    <div class="col-xs-pull-9" align="left">

                        <div style="color:purple;margin:1em 0">
                            <?= Html::a('Go back to Login Page', ['site/login']) ?>
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
    </div>
    </div>
<?php  $this->endBody() ?>


</div>

        <div class="text-center">
            <strong style="color: whitesmoke" >Copyright &copy; <b style="color: whitesmoke">HR & PAYROLL MIS</b> <?= date("Y") ?>
            </strong>
        </div>