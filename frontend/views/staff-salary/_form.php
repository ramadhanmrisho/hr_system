<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\StaffSalary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="staff-salary-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'staff_id')->textInput() ?>

    <?= $form->field($model, 'date')->widget(\dosamigos\datepicker\DatePicker::className(),[
                'clientOptions'=>['format'=>'dd-mm-yyyy','autoclose'=>true],'options'=>['autocomplete'=>'off']
            ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
