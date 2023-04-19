<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\GpaClass */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gpa-class-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'starting_point')->textInput() ?>

    <?= $form->field($model, 'end_point')->textInput() ?>

    <?= $form->field($model, 'gpa_class')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year_of_study_id')->widget(\kartik\select2\Select2::className(),             ['data'=>\yii\helpers\ArrayHelper::map(\common\models\YearOfStudy::find()->all(),'id','name'),             'options'=>['placeholder'=>'--Select--']]) ?>

    <?= $form->field($model, 'academic_year_id')->widget(\kartik\select2\Select2::className(),             ['data'=>\yii\helpers\ArrayHelper::map(\common\models\AcademicYear::find()->all(),'id','name'),             'options'=>['placeholder'=>'--Select--']]) ?>

    <?= $form->field($model, 'course_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
