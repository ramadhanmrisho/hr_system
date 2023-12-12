<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DeductionsPercentage */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="deductions-percentage-form">

    <?php $form = ActiveForm::begin(); ?>

   <div class="row">
       <div class="col-md-3">
           <?= $form->field($model, 'NSSF')->textInput() ?>
       </div>
       <div class="col-md-3">
           <?= $form->field($model, 'WCF')->textInput() ?>

       </div>
       <div class="col-md-3">
       <?= $form->field($model, 'SDL')->textInput() ?>
       </div>
       <div class="col-md-3">
           <?= $form->field($model, 'NHIF')->textInput() ?>
       </div>

   </div>



    <div class="form-group" align="center">
        <?= Html::submitButton('Save Details', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
