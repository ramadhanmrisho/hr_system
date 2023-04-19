<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AuthAssignment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-assignment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'auth_item')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'assigned_date')->widget(\dosamigos\datepicker\DatePicker::className(),[
                'clientOptions'=>['format'=>'dd-mm-yyyy','autoclose'=>true],'options'=>['autocomplete'=>'off']
            ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
