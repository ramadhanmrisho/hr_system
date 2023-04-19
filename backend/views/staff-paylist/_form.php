<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\StaffPaylist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="staff-paylist-form">

    <?php $form = ActiveForm::begin(); ?>
    <fieldset>

        <div class="panel panel-default fadeIn" style="border-bottom:4px solid dodgerblue;border-top:4px solid dodgerblue;  padding:20px; ">
            <div class="panel-body" style="font-weight: bold;">

                <div class="col-md-6">

                    <?= $form->field($model, 'month',['options'=>['class'=>'required']])->dropDownList([ 'January' => 'January', 'February' => 'February',
                        'March' => 'March', 'April' => 'April', 'May' => 'May', 'June' => 'June', 'July' => 'July', 'August' => 'August', 'September' => 'September', 'October' => 'October', 'November' => 'November', 'December' => 'December',], ['prompt' => 'Select Month']) ?>
                </div>

    </fieldset>
    <div class="form-group">
        <?= Html::submitButton('Generate Paylist', ['class' => 'btn btn-success',

            'data' => [
                'confirm' => 'Are you sure you want to Generate Paylist?',
                'method' => 'post',
            ],
        ]) ?>

    </div>

    <?php ActiveForm::end(); ?>
</div>


<div>


</div>
