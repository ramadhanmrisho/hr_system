<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Designation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="designation-form">
    <div class="panel panel-default fadeIn" style="border-top:4px solid dodgerblue; padding:20px;">
        <div class="panel-body" style="font-weight: bold;">
    <?php $form = ActiveForm::begin(); ?>
<fieldset>
    <div class="col-md-4">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'abbreviation')->textInput(['maxlength' => true]) ?>
    </div>
</fieldset>
    <div class="form-group" align="center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
