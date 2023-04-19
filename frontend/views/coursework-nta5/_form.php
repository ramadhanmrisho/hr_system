<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CourseworkNta5 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="coursework-nta5-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'student_id')->textInput() ?>

    <?= $form->field($model, 'module_id')->textInput() ?>

    <?= $form->field($model, 'cat_1')->textInput() ?>

    <?= $form->field($model, 'cat_2')->textInput() ?>

    <?= $form->field($model, 'assignment_1')->textInput() ?>

    <?= $form->field($model, 'assignment_2')->textInput() ?>

    <?= $form->field($model, 'practical')->textInput() ?>

    <?= $form->field($model, 'ppb')->textInput() ?>

    <?= $form->field($model, 'practical_2')->textInput() ?>

    <?= $form->field($model, 'total_score')->textInput() ?>

    <?= $form->field($model, 'remarks')->dropDownList([ 'Passed' => 'Passed', 'Failed' => 'Failed', 'Incomplete' => 'Incomplete', 'N/A' => 'N/A', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'academic_year_id')->textInput() ?>

    <?= $form->field($model, 'year_of_study_id')->textInput() ?>

    <?= $form->field($model, 'course_id')->textInput() ?>

    <?= $form->field($model, 'semester_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'staff_id')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
