<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\District */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="district-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-default fadeIn" style="border-top:4px solid dodgerblue; border-radius: 20px; padding:20px;">
        <div class="panel-body" style="font-weight: bold;">
            <fieldset>
<div class="col-md-4">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
</div>
            <div class="col-md-4">
    <?= $form->field($model, 'region_id')->widget(\kartik\select2\Select2::className(), ['data'=>\yii\helpers\ArrayHelper::map(\common\models\Region::find()->all(),'id','name'),             'options'=>['placeholder'=>'--Select--']]) ?>
            </div>
            </fieldset>
    <div class="form-group" align="center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
