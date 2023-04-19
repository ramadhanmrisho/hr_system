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

    <?= $form->field($model, 'academic_year_id')->textInput() ?>

    <?= $form->field($model, 'year_of_study_id')->textInput() ?>

    <?= $form->field($model, 'course_id')->textInput() ?>

    <?= $form->field($model, 'semester_id')->textInput() ?>

    <?= $form->field($model, 'module_id')->textInput() ?>

    <?= $form->field($model, 'coursework')->textInput() ?>

    <?= $form->field($model, 'final_exam_id')->textInput() ?>

    <?= $form->field($model, 'total_score')->textInput() ?>

    <?= $form->field($model, 'grade_id')->textInput() ?>

    <?= $form->field($model, 'remarks')->dropDownList([ 'Pass' => 'Pass', 'Fail' => 'Fail', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'category')->dropDownList([ 'Normal' => 'Normal', 'Repeated' => 'Repeated', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'Wait for Approval' => 'Wait for Approval', 'Released' => 'Released', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
