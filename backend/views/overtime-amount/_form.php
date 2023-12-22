<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OvertimeAmount */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="overtime-amount-form">

    <?php $form = ActiveForm::begin(); ?>

   <div class="row">
       <div class="col-md-6">
           <?= $form->field($model, 'special_ot_amount')->textInput() ?>
       </div>
       <div class="col-md-6">
           <?= $form->field($model, 'normal_ot_amount')->textInput() ?>
       </div>
   </div>

    <div class="form-group" align="center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
