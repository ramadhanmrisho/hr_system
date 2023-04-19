<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Course */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-form">

    <?php $form = ActiveForm::begin(); ?>
<fieldset>

    <?= $form->field($model, 'course_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'duration_in_years')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'abbreviation')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'department_id',['options'=>['class'=>'required']])->widget(\kartik\select2\Select2::className(), ['data'=> ArrayHelper::map(\common\models\Department::find()->all(),'id','name'),'options'=>['placeholder'=>'--Select Department--']]) ?>




    <div class="form-group">
        <?= Html::submitButton(($model->isNewRecord) ? 'Save ' : 'Save Changes', ['class' => 'btn btn-success btn-fill pull-right','style'=>'min-width:90px;','id'=>'prod']) ?>
        <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>

    </div>
</fieldset>
    <?php ActiveForm::end(); ?>

</div>
