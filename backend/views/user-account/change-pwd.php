<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Change Password';
$this->params['breadcrumbs'][] = $this->title;
$this->params['pass'] = 'active opened active';
?>

<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>


    <div class="modalContent" >
        <div class="col-md-12">

            <?php $form = ActiveForm::begin([
                'id'=>'changepassword-form',
                'options'=>['class'=>'form-horizontal'],

            ]); ?>

            <?= $form->field($model,'newpass',['inputOptions'=>[
                'placeholder'=>'New Password'
            ]])->passwordInput() ?>

            <?= $form->field($model,'repeatnewpass',['inputOptions'=>[
                'placeholder'=>'Repeat New Password'
            ]])->passwordInput() ?>

            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-4">
                    <?= Html::submitButton('Change password',[
                        'class'=>'btn btn-primary'
                    ]) ?>
                </div>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

<?php \yiister\adminlte\widgets\Box::end() ?>