<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PostponedStudent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="postponed-student-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'student_id')->textInput() ?>

    <?= $form->field($model, 'postone_to')->textInput() ?>

    <?= $form->field($model, 'academic_year_id')->widget(\kartik\select2\Select2::className(),             ['data'=>\yii\helpers\ArrayHelper::map(\common\models\AcademicYear::find()->all(),'id','name'),             'options'=>['placeholder'=>'--Select--']]) ?>

    <?= $form->field($model, 'reason')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'Approved' => 'Approved', 'Resumed' => 'Resumed', 'Rejected' => 'Rejected', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'duration')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
