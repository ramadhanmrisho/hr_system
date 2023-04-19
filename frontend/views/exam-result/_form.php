<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ExamResult */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="exam-result-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'student_id')->textInput() ?>

    <?= $form->field($model, 'academic_year_id')->widget(\kartik\select2\Select2::className(),             ['data'=>\yii\helpers\ArrayHelper::map(\common\models\AcademicYear::find()->all(),'id','name'),             'options'=>['placeholder'=>'--Select--']]) ?>

    <?= $form->field($model, 'year_of_study_id')->widget(\kartik\select2\Select2::className(),             ['data'=>\yii\helpers\ArrayHelper::map(\common\models\YearOfStudy::find()->all(),'id','name'),             'options'=>['placeholder'=>'--Select--']]) ?>

    <?= $form->field($model, 'course_id')->textInput() ?>

    <?= $form->field($model, 'semester_id')->widget(\kartik\select2\Select2::className(),             ['data'=>\yii\helpers\ArrayHelper::map(\common\models\Semester::find()->all(),'id','name'),             'options'=>['placeholder'=>'--Select--']]) ?>

    <?= $form->field($model, 'coursework_id')->textInput() ?>

    <?= $form->field($model, 'final_exam_id')->textInput() ?>

    <?= $form->field($model, 'module_id')->textInput() ?>

    <?= $form->field($model, 'total_score')->textInput() ?>

    <?= $form->field($model, 'category')->dropDownList([ 'Normal' => 'Normal', 'Repeated' => 'Repeated', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'Released' => 'Released', 'Waiting for Approval' => 'Waiting for Approval', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
