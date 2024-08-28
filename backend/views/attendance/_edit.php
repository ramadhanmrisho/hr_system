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
    
    <?= $form->field($model, 'signin_at')->textInput() ?>

    <?= $form->field($model, 'singout_at')->textInput() ?>

    <?= $form->field($model, 'status',['options'=>['class'=>'required']])->widget(\kartik\select2\Select2::className(), ['data'=>[ 'Unpaid Leave'=>'Unpaid Leave','Absent'=>'Absent','Annual Leave' => 'Annual Leave', 'Paternity Leave' => 'Paternity Leave','Maternity Leave'=>'Maternity Leave','Compassionate Leave'=>'Compassionate Leave'],'options'=>['placeholder'=>'--Select Status--']]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
