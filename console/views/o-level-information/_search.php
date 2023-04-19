<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\OLevelInformationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="olevel-information-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name_of_school') ?>

    <?= $form->field($model, 'index_number') ?>

    <?= $form->field($model, 'student_id') ?>

    <?= $form->field($model, 'division') ?>

    <?php // echo $form->field($model, 'o_level_certificate') ?>

    <?php // echo $form->field($model, 'award') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
