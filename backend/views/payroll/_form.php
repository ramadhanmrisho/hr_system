<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Payroll */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payroll-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'payroll_transaction_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 1 => '1', 2 => '2', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
