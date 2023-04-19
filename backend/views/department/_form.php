<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Department */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="department-form">
    <div class="panel panel-default fadeIn" style="border-top:4px solid dodgerblue; border-radius: 20px; padding:20px;">
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
        <?= Html::submitButton(($model->isNewRecord) ? 'Save Details ' : 'Save Changes', ['class' => 'btn btn-success btn-fill','style'=>'min-width:100px;']) ?>

    </div>

    <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
