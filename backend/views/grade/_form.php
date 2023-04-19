<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Grade */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grade-form">

    <?php $form = ActiveForm::begin(); ?>

    <fieldset>
        <div class="col-md-4">
            <?= $form->field($model, 'lower_score')->textInput() ?>
            <?= $form->field($model, 'point')->textInput() ?>
            <?= $form->field($model, 'academic_year_id')->widget(\kartik\select2\Select2::className(), ['data'=>\yii\helpers\ArrayHelper::map(\common\models\AcademicYear::find()->all(),'id','name'),             'options'=>['placeholder'=>'--Select--']]) ?>



        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'upper_score')->textInput() ?>
            <?= $form->field($model, 'description')->dropDownList([ 'Excellent' => 'Excellent', 'Good' => 'Good', 'Satisfactory' => 'Satisfactory', 'Poor' => 'Poor', 'Failure' => 'Failure', 'Incomplete' => 'Incomplete', 'Disqualification' => 'Disqualification', ], ['prompt' => '']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'grade')->textInput(['maxlength' => true]) ?>


            <?= $form->field($model, 'nta_level')->dropDownList([ '4' => '4', '5' => '5', '6' => '6' ], ['prompt' => '']) ?>

        </div>

    </fieldset>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success pull-right','style'=>'min-width:130px']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
