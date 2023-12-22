<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\PayrollTransactionsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payroll-transactions-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'staff_id') ?>

    <?= $form->field($model, 'departiment_id') ?>

    <?= $form->field($model, 'designation_id') ?>

    <?= $form->field($model, 'basic_salary') ?>

    <?php // echo $form->field($model, 'salary_adjustiment_id') ?>

    <?php // echo $form->field($model, 'allowances') ?>

    <?php // echo $form->field($model, 'night_hours') ?>

    <?php // echo $form->field($model, 'night_allowance') ?>

    <?php // echo $form->field($model, 'normal_ot_hours') ?>

    <?php // echo $form->field($model, 'special_ot_hours') ?>

    <?php // echo $form->field($model, 'normal_ot_amount') ?>

    <?php // echo $form->field($model, 'special_ot_amount') ?>

    <?php // echo $form->field($model, 'absent_days') ?>

    <?php // echo $form->field($model, 'absent_amount') ?>

    <?php // echo $form->field($model, 'total_earnings') ?>

    <?php // echo $form->field($model, 'nssf') ?>

    <?php // echo $form->field($model, 'taxable_income') ?>

    <?php // echo $form->field($model, 'paye') ?>

    <?php // echo $form->field($model, 'loan') ?>

    <?php // echo $form->field($model, 'salary_advance') ?>

    <?php // echo $form->field($model, 'union_contibution') ?>

    <?php // echo $form->field($model, 'net_salary') ?>

    <?php // echo $form->field($model, 'wcf') ?>

    <?php // echo $form->field($model, 'sdl') ?>

    <?php // echo $form->field($model, 'nhif') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
