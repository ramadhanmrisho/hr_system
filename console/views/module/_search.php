<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\ModuleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="module-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'module_name') ?>

    <?= $form->field($model, 'module_code') ?>

    <?= $form->field($model, 'course_id') ?>

    <?= $form->field($model, 'year_of_study_id') ?>

    <?php // echo $form->field($model, 'nta_level') ?>

    <?php // echo $form->field($model, 'prerequisite') ?>

    <?php // echo $form->field($model, 'semester_id') ?>

    <?php // echo $form->field($model, 'lect_hrs_per_week') ?>

    <?php // echo $form->field($model, 'tut_hrs_per_week') ?>

    <?php // echo $form->field($model, 'practical_hrs_per_week') ?>

    <?php // echo $form->field($model, 'class_practical_on_ca') ?>

    <?php // echo $form->field($model, 'ppb') ?>

    <?php // echo $form->field($model, 'final_practical') ?>

    <?php // echo $form->field($model, 'portifolio') ?>

    <?php // echo $form->field($model, 'delivery_book') ?>

    <?php // echo $form->field($model, 'proposal_report') ?>

    <?php // echo $form->field($model, 'category') ?>

    <?php // echo $form->field($model, 'module_credit') ?>

    <?php // echo $form->field($model, 'contact_hours') ?>

    <?php // echo $form->field($model, 'noncontact_hours') ?>

    <?php // echo $form->field($model, 'academic_year_id') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
