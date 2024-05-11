<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
$this->title = 'Sign In';

$this ->beginBody();


?>



 <strong>
    <?php if (Yii::$app->session->hasFlash('danger')): ?>
        <div class="col-sm-12 alert alert-danger alert-dismissable align-content-center" align="center" style="text-align: center">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>

            <h4>  <?= Yii::$app->session->getFlash('danger') ?></h4>
        </div>
    <?php endif; ?>
    <?php
    if(Yii::$app->session->hasFlash('success')):?>
        <div class="alert alert-sm alert-success zoomIn" align="center">
            <?= Yii::$app->session->getFlash('success');?>
        </div>
    <?php endif;?>

</strong>

<div class="login-box" style="height:65px; width:358px;font-family: Lucida Bright overflow:unset">
   
    <div class="login-logo">

    </div>
    <!-- /.login-logo -->
    <div class="panel panel-default fadeIn" style="padding:20px;border-radius: 25px;">
        <div class="panel-body ">
    <div class="wrap-inner" style="border-bottom: 5px solid dodgerblue;border-top: 5px solid  dodgerblue;">
    <!--kibox cha ndani-->
        <div class="login-box-body"  style="height: 355px;"  style="alignment:left;overflow:hidden">


        <div style="text-align: center">
            <img src="images/pay.jpeg" width="150px" height="130px" class="img-circle">
        </div>
        <br>
        <div class="login-box-msg"  style= "font-size:xx-large ;font-weight: bold;color: black" > <h4 style="font-family: 'Tahoma';font-weight: bold">Sign In</>
<!--            <h5 style="font-weight: bold; color: black;font-family: 'Tahoma'">Please fill out the following fields to Sign In</h5>-->
        </div>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>


        <fieldset>
            <div class="col-md-20">
            <br >
                <?= $form->field($model, 'username',['template'=>'{beginLabel}{labelTitle}{endLabel}<div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user" style="color:dodgerblue;"></i></span>{input}</div>{error}{hint}'])->textInput(['placeholder'=>'Staff Number'])->label(false) ?>
     

                <?= $form->field($model, 'password',['template'=>'{beginLabel}{labelTitle}{endLabel}<div class="input-group">
                            <span class="input-group-addon" id="password-view-icon"><i class="glyphicon glyphicon-lock" style="color:dodgerblue;"></i></span>{input}</div>{error}{hint}'])->passwordInput(['placeholder'=>'Password'])->label(false) ?>

<!--                --><?php //= $form->field($model, 'password', [
//                    'options' => ['class' => 'form-group has-feedback'],
//                    'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-append">
//                <span class="input-group-text" id="toggle-password">
//                    <i class="fa fa-eye-slash" aria-hidden="true"></i>
//                </span></div></div>',
//                    'template' => '{beginWrapper}{input}{error}{endWrapper}',
//                    'wrapperOptions' => ['class' => 'input-group mb-3']
//                ])
//                    ->label(false)
//                    ->passwordInput(['placeholder' => $model->getAttributeLabel('password'), 'id' => 'password']) ?>
            </div>
        </fieldset>
            </div>
        </fieldset>
        <div class="row">
            <div class="col-xs-8" align="left">

                <div style="color:#999;margin:1em 0">
<?= Html::a('<b style="font-family: Tahoma">I forgot My  password</b>', ['site/request-password-reset']) ?>
                </div>

            </div>
            <!-- /.col -->
            <div class="col-xs-4" align="left">
                <?= Html::submitButton('<span class="fa fa-sign-in "> Sign In</span>', ['class' => 'btn btn-primary btn-block btn-block', 'name' => 'login-button','style'=>'min-width:90px;']) ?>

            </div>
            <!-- /.col -->
        </div>
        <?php ActiveForm::end(); ?>
    </div>
        </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->

<?php  $this->endBody() ?>

</div>





    <script>
        document.getElementById('toggle-password').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                this.querySelector('i').classList.remove('fa-eye-slash');
                this.querySelector('i').classList.add('fa-eye');
            } else {
                passwordField.type = 'password';
                this.querySelector('i').classList.remove('fa-eye');
                this.querySelector('i').classList.add('fa-eye-slash');
            }
        });
    </script>

