<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ParentInformation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parent-information-form">

    <?php $form = ActiveForm::begin(); ?>


    <fieldset>
        <div class="col-md-4">
            <?= $form->field($model, 'full_name')->textInput() ?>
          
            <?= $form->field($model, 'physical_address')->textInput(['maxlength' => true]) ?>

        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'phone_number')->textInput() ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'gender')->dropDownList([ 'Male' => 'Male', 'Female' => 'Female', ], ['prompt' => '']) ?>

        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'nationality_id')->widget(\kartik\select2\Select2::className(),             ['data'=>\yii\helpers\ArrayHelper::map(\common\models\Nationality::find()->all(),'id','name'),             'options'=>['placeholder'=>'--Select--']]) ?>
            <?= $form->field($model, 'relationship')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'occupation')->textInput(['maxlength' => true]) ?>
        </div>
    </fieldset>
    <div class="form-group" align="right">
        <?= Html::submitButton('Save Changes', ['class' => 'btn btn-success',

            'data'=>[
                    'confirm'=>"Are you sure you want to save Changes ?",
                "method"=>"post"
            ]]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
