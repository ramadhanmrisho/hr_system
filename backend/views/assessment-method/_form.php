<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AssessmentMethod */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="assessment-method-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nta_level')->dropDownList([ '4' => '4', '5' => '5', '6' => '6' ], ['prompt' => '']) ?>
    <?= $form->field($model, 'course_id')->widget(\kartik\select2\Select2::className(),['data'=>\yii\helpers\ArrayHelper::map(\common\models\Course::find()->all(),'id','course_name'),             'options'=>['placeholder'=>'--Select--']]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal" >Cancel</button>
    </div>
    <?php ActiveForm::end(); ?>

</div>
