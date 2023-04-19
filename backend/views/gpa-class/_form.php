<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\GpaClass */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gpa-class-form">

    <?php $form = ActiveForm::begin(); ?>

    <fieldset>
    <div class="col-md-4">
    <?= $form->field($model, 'starting_point')->textInput() ?>
    <?= $form->field($model, 'course_id')->widget(\kartik\select2\Select2::className(),['data'=>\yii\helpers\ArrayHelper::map(\common\models\Course::find()->all(),'id','course_name'),'options'=>['placeholder'=>'--Select--']]) ?>
    </div>
        <div class="col-md-4">
            <?= $form->field($model, 'end_point')->textInput() ?>
            <?= $form->field($model, 'academic_year_id')->widget(\kartik\select2\Select2::className(),['data'=>\yii\helpers\ArrayHelper::map(\common\models\AcademicYear::find()->all(),'id','name'),             'options'=>['placeholder'=>'--Select--']]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'gpa_class')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'nta_level')->widget(\kartik\select2\Select2::className(),['data'=>[ '4' => '4', '6' => '6' ],'options'=>['placeholder'=>'--Select--']]) ?>
        </div>
    </fieldset>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success pull-right','style'=>'min-width:120px']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
