<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Dependants */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dependants-form" id="modalContent1">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->dropDownList([ 'MALE' => 'MALE', 'FEMALE' => 'FEMALE', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'dob',['options'=>['class'=>'required']])->widget(\dosamigos\datepicker\DatePicker::className(),['clientOptions'=>['format'=>'yyyy-mm-dd','autoclose'=>true],'options'=>['autocomplete'=>'off']]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
