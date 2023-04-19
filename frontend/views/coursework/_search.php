<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\CourseworkSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="coursework-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'student_id') ?>

    <?= $form->field($model, 'module_id') ?>

    <?= $form->field($model, 'test_1') ?>

    <?= $form->field($model, 'test_2') ?>

    <?php // echo $form->field($model, 'assignment_1') ?>

    <?php // echo $form->field($model, 'assignment_2') ?>

    <?php // echo $form->field($model, 'class_practical') ?>

    <?php // echo $form->field($model, 'final_practical') ?>

    <?php // echo $form->field($model, 'ppb') ?>

    <?php // echo $form->field($model, 'portifolio') ?>

    <?php // echo $form->field($model, 'total_score') ?>

    <?php // echo $form->field($model, 'academic_year_id') ?>

    <?php // echo $form->field($model, 'year_of_study_id') ?>

    <?php // echo $form->field($model, 'course_id') ?>

    <?php // echo $form->field($model, 'semester_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'staff_id') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
