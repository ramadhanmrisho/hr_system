<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\time\TimePicker;


/* @var $this yii\web\View */
/* @var $model common\models\Attendance */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="attendance-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'staff_id',['options'=>['class'=>'required']])->widget(\kartik\select2\Select2::className(), ['data'=> ArrayHelper::map(\common\models\Staff::find()->all(),'id',function ($model){
        return $model->fname.' '.$model->lname;
    }),             'options'=>['placeholder'=>'--Select Staff--']]) ?>

    <?= $form->field($model, 'date',['options'=>['class'=>'required']])->widget(\dosamigos\datepicker\DatePicker::className(),['clientOptions'=>['format'=>'yyyy-mm-dd','autoclose'=>true],'options'=>['autocomplete'=>'off']]) ?>


<!--    --><?php //= $form->field($model, 'signin_at')->widget(TimePicker::classname(), []); ?>
    <?= $form->field($model, 'signin_at')->widget(TimePicker::classname(), []); ?>


    <?= $form->field($model, 'singout_at')->widget(TimePicker::classname(), []); ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
