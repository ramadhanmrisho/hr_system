<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Student */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-form">



    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <fieldset>
        <div class="col-md-3">
               <?= $form->field($model, 'fname')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'mname')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'lname')->textInput() ?>

        

            <?= $form->field($model, 'dob')->widget(DatePicker::className(),[
                'clientOptions'=>['format'=>'dd-mm-yyyy','autoclose'=>true],'options'=>['autocomplete'=>'off']
            ]) ?>

            <?= $form->field($model, 'place_of_birth')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'sponsorship')->dropDownList([ 'Private' => 'Private', 'HESLB' => 'HESLB', 'Sponsor' => 'Sponsor', ], ['prompt' => '']) ?>
            <?= $form->field($model, 'intake_type')->dropDownList([ 'March' => 'March', 'September' => 'September', ], ['prompt' => '']) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'phone_number')->textInput() ?>

            <?= $form->field($model, 'identity_type_id')->widget(Select2::className(),   ['data'=>\yii\helpers\ArrayHelper::map(\common\models\IdentityType::find()->all(),'id','name'),'options'=>['placeholder'=>'--Select--']]) ?>

            <?= $form->field($model, 'id_number')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'marital_status')->dropDownList([ 'Married' => 'Married', 'Single' => 'Single', 'Divorced' => 'Divorced', ], ['prompt' => '']) ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'status')->dropDownList([ 'First Year' => 'First Year', 'Continuing' => 'Continuing', 'Discontinuing' => 'Discontinuing', 'Completed' => 'Completed', ], ['prompt' => '']) ?>

        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'gender')->dropDownList([ 'Male' => 'Male', 'Female' => 'Female', ], ['prompt' => '']) ?>


            <?= $form->field($model, 'registration_number')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'nationality_id')->widget(Select2::className(), ['data'=>\yii\helpers\ArrayHelper::map(\common\models\Nationality::find()->all(),'id','name'), 'options'=>['placeholder'=>'--Select--']]) ?>

            <?= $form->field($model, 'region_id')->widget(Select2::className(), ['data'=>\yii\helpers\ArrayHelper::map(\common\models\Region::find()->all(),'id','name'),             'options'=>['placeholder'=>'--Select--']]) ?>

            <?= $form->field($model, 'district_id')->widget(Select2::className(),             ['data'=>\yii\helpers\ArrayHelper::map(\common\models\District::find()->all(),'id','name'),             'options'=>['placeholder'=>'--Select--']]) ?>
            <?= $form->field($model, 'date_of_admission')->widget(DatePicker::className(),[
                'clientOptions'=>['format'=>'dd-mm-yyyy','autoclose'=>true],'options'=>['autocomplete'=>'off']
            ]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'village')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'academic_year_id')->widget(Select2::className(),             ['data'=>\yii\helpers\ArrayHelper::map(\common\models\AcademicYear::find()->all(),'id','name'),             'options'=>['placeholder'=>'--Select--']]) ?>

            <?= $form->field($model, 'home_address')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'course_id')->textInput() ?>

            <?= $form->field($model, 'nta_level',['options'=>['class'=>'required']])->dropDownList([ '4' => '4', '5' => '5', '6' => '6' ], ['prompt' => '']) ?>

            <?= $form->field($model, 'college_residence')->dropDownList([ 'Off Campus' => 'Off Campus', 'Hostel' => 'Hostel', ], ['prompt' => '']) ?>
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
