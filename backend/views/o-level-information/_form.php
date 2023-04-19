<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OLevelInformation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="olevel-information-form">


    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <fieldset>
        <div class="col-md-3">
            <?= $form->field($model, 'name_of_school')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'Physics')->dropDownList([ 'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'F' => 'F', ], ['prompt' => '']) ?>
            <?= $form->field($model, 'Mathematics')->dropDownList([ 'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'F' => 'F', ], ['prompt' => '']) ?>



        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'index_number')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'Chemistry')->dropDownList([ 'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'F' => 'F', ], ['prompt' => '']) ?>
            <?= $form->field($model, 'Biology')->dropDownList([ 'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'F' => 'F', ], ['prompt' => '']) ?>

        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'year_of_complition')->textInput() ?>

            <?= $form->field($model, 'English')->dropDownList([ 'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'F' => 'F', ], ['prompt' => '']) ?>
            <?= $form->field($model, 'division')->dropDownList([ 'I' => 'I', 'II' => 'II', 'III' => 'III', 'IV' => 'IV', ], ['prompt' => '']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'o_level_certificate',['options'=>['class'=>'required']])->widget(\kartik\file\FileInput::className(),[
                'options' => ['accept'=>'*', 'required' => false],
                'pluginOptions' => ['allowedFileExtensions' => ['jpg','png','jepg','pdf'], 'showUpload' => false]
            ]); ?>
        </div>
    </fieldset>




    <div class="form-group" align="center">
        <?= Html::submitButton('Save Changes', ['class' => 'btn btn-success',
            'data'=>[
                'confirm'=>"Are you sure you want to save Changes ?",
                "method"=>"post"
            ]]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
