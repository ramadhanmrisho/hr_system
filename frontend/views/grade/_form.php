<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Grade */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grade-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lower_score')->textInput() ?>

    <?= $form->field($model, 'upper_score')->textInput() ?>

    <?= $form->field($model, 'grade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year_of_study')->textInput() ?>

    <?= $form->field($model, 'academic_year_id')->widget(\kartik\select2\Select2::className(),             ['data'=>\yii\helpers\ArrayHelper::map(\common\models\AcademicYear::find()->all(),'id','name'),             'options'=>['placeholder'=>'--Select--']]) ?>

    <?= $form->field($model, 'course_id')->textInput() ?>

    <?= $form->field($model, 'point')->textInput() ?>

    <?= $form->field($model, 'description')->dropDownList([ 'Excellent' => 'Excellent', 'Very Good' => 'Very Good', 'Good' => 'Good', 'Average' => 'Average', 'Poor' => 'Poor', 'Very Poor' => 'Very Poor', 'Fail' => 'Fail', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
