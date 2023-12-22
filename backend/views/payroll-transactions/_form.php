<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PayrollTransactions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payroll-transactions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'staff_id')->textInput() ?>

    <?= $form->field($model, 'departiment_id')->textInput() ?>

    <?= $form->field($model, 'designation_id')->textInput() ?>

    <?= $form->field($model, 'basic_salary')->textInput() ?>

    <?= $form->field($model, 'salary_adjustiment_id')->textInput() ?>

    <?= $form->field($model, 'allowances')->textInput() ?>

    <?= $form->field($model, 'night_hours')->textInput() ?>

    <?= $form->field($model, 'night_allowance')->textInput() ?>

    <?= $form->field($model, 'normal_ot_hours')->textInput() ?>

    <?= $form->field($model, 'special_ot_hours')->textInput() ?>

    <?= $form->field($model, 'normal_ot_amount')->textInput() ?>

    <?= $form->field($model, 'special_ot_amount')->textInput() ?>

    <?= $form->field($model, 'absent_days')->textInput() ?>

    <?= $form->field($model, 'absent_amount')->textInput() ?>

    <?= $form->field($model, 'total_earnings')->textInput() ?>

    <?= $form->field($model, 'nssf')->textInput() ?>

    <?= $form->field($model, 'taxable_income')->textInput() ?>

    <?= $form->field($model, 'paye')->textInput() ?>

    <?= $form->field($model, 'loan')->textInput() ?>

    <?= $form->field($model, 'salary_advance')->textInput() ?>

    <?= $form->field($model, 'union_contibution')->textInput() ?>

    <?= $form->field($model, 'net_salary')->textInput() ?>

    <?= $form->field($model, 'wcf')->textInput() ?>

    <?= $form->field($model, 'sdl')->textInput() ?>

    <?= $form->field($model, 'nhif')->textInput() ?>

    <?= $form->field($model, 'total')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
