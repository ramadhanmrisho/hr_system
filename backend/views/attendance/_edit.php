<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Attendance */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="attendance-form">

    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'date')->textInput() ?>

<!--    --><?php //= $form->field($model, 'signin_at')->widget(TimePicker::classname(), []); ?>
<!---->
<!---->
<!--    --><?php //= $form->field($model, 'singout_at')->widget(TimePicker::classname(), []); ?>

    <?= $form->field($model, 'signin_at')->textInput() ?>

    <?= $form->field($model, 'singout_at')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
