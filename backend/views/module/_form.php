<?php

use common\models\AssessmentMethod;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use unclead\multipleinput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;



/* @var $this yii\web\View */
/* @var $model common\models\Module */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="module-form">

    <?php $form = ActiveForm::begin(); ?>
    <fieldset>
        <legend style="font-weight: bold;font-family: 'Bell MT';color: #0d6aad">Module Details:</legend>
        <div class="col-md-4">
            <?= $form->field($model, 'module_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'prerequisite')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'module_code')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'semester_id')->widget(\kartik\select2\Select2::className(),['data'=>\yii\helpers\ArrayHelper::map(\common\models\Semester::find()->all(),'id','name'),'options'=>['placeholder'=>'--Select--']]) ?>

            <?= $form->field($model, 'nta_level')->widget(\kartik\select2\Select2::className(),['data'=>[ '4' => '4', '5' => '5', '6' => '6' ],

                'language' => 'en',
                'options' => ['placeholder' => 'Select Level ...', 'multiple' => false,
                    'onchange' => '
                                            $.post( "index.php?r=module/listmethod&id=' . '"+$(this).val(), function( data ) {
                                              $( ".assessment_methods_id" ).html( data );
                                              
                                            });'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],]) ?>







        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'course_id')->widget(\kartik\select2\Select2::className(),['data'=>\yii\helpers\ArrayHelper::map(\common\models\Course::find()->all(),'id','course_name'),             'options'=>['placeholder'=>'--Select--']]) ?>
            <?= $form->field($model, 'module_credit')->textInput() ?>
            <?= $form->field($model, 'department_id',['options'=>['class'=>'required']])->widget(\kartik\select2\Select2::className(), ['data'=> ArrayHelper::map(\common\models\Department::find()->all(),'id','name'),'options'=>['placeholder'=>'--Select Department--']]) ?>

        </div>
    </fieldset>
    <fieldset>
        <legend style="font-weight: bold;font-family: 'Bell MT';color: #0d6aad">Assessment Methods:</legend>
        <?=  $form->field($model,'assessment_methods')->widget(multipleinput\MultipleInput::className(),[
            'max' => 15,
            'addButtonOptions' => [
                'class' => 'btn btn-primary',
                'label' => '<span class=" fa fa-plus-circle"></span>Add Column'
            ],
            'removeButtonOptions' => [
                'class' => 'btn btn-danger',
                'label' => 'Remove'
            ],
            'columns'=>[
                ['name'=>'assessment_method_id',
                    'type'=>Select2::className(),
                    'title'=>'Assessment Method',
                    'options'=>[
                        'data'=>[],
                        'language' => 'en',
                        'options' => ['placeholder' => 'Select Method ...', 'multiple' => false,
                         'class'=>'assessment_methods_id'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]
                ],
                [
                    'name'  => 'category',
                    'type'  => 'dropDownList',
                    'title' => 'Category',
                       'options' => [
                'prompt' => '----Select-----'
            ],
                    'items' => [
                        'CA' => ' Continuous Assessment',
                        'SE' => 'Semester Exam'
                    ]
                ],
                [
                    'name'=>'percent',
                    'title'=>'Percent(%)',
                ],



            ]
        ])->label(false)?>


    </fieldset>

    <div class="form-group" align="center">
        <?= Html::submitButton(($model->isNewRecord) ? 'Save Details ' : 'Save Changes', ['class' => 'btn btn-success ','style'=>'min-width:150px;',
            'data' => [
                'confirm' => 'Are you sure you want to save Module details?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
