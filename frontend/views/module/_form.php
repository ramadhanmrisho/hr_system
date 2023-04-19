<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Module */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="module-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'module_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'module_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'course_id')->textInput() ?>

    <?= $form->field($model, 'year_of_study_id')->widget(\kartik\select2\Select2::className(),             ['data'=>\yii\helpers\ArrayHelper::map(\common\models\YearOfStudy::find()->all(),'id','name'),             'options'=>['placeholder'=>'--Select--']]) ?>

    <?= $form->field($model, 'nta_level')->dropDownList([ 4 => '4', 5 => '5', 6 => '6', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'prerequisite')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'semester_id')->widget(\kartik\select2\Select2::className(),             ['data'=>\yii\helpers\ArrayHelper::map(\common\models\Semester::find()->all(),'id','name'),             'options'=>['placeholder'=>'--Select--']]) ?>

    <?= $form->field($model, 'lect_hrs_per_week')->textInput() ?>

    <?= $form->field($model, 'tut_hrs_per_week')->textInput() ?>

    <?= $form->field($model, 'practical_hrs_per_week')->textInput() ?>

    <?= $form->field($model, 'class_practical_on_ca')->dropDownList([ 'Yes' => 'Yes', 'No' => 'No', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'ppb')->dropDownList([ 'Yes' => 'Yes', 'No' => 'No', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'final_practical')->dropDownList([ 'Yes' => 'Yes', 'No' => 'No', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'portifolio')->dropDownList([ 'Yes' => 'Yes', 'No' => 'No', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'delivery_book')->dropDownList([ 'Yes' => 'Yes', 'No' => 'No', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'proposal_report')->dropDownList([ 'Yes' => 'Yes', 'No' => 'No', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'category')->dropDownList([ 'Core' => 'Core', 'Optional' => 'Optional', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'module_credit')->textInput() ?>

    <?= $form->field($model, 'contact_hours')->textInput() ?>

    <?= $form->field($model, 'noncontact_hours')->textInput() ?>

    <?= $form->field($model, 'academic_year_id')->widget(\kartik\select2\Select2::className(),             ['data'=>\yii\helpers\ArrayHelper::map(\common\models\AcademicYear::find()->all(),'id','name'),             'options'=>['placeholder'=>'--Select--']]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
