<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\UserAccount;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model common\models\Assignment */
/* @var $form yii\widgets\ActiveForm */
?>
<style>

    form div.required label.control-label:after {

        content:" * ";

        color:red;

    }
</style>
<div class="assignment-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
    <fieldset>
        <div class="col-md-4">
            <?php
            $active_semester=\common\models\Semester::find()->where(['status'=>'Active'])->one()->id;
            $active_year=\common\models\AcademicYear::find()->where(['status'=>'Active'])->one()->id;
           
           if(!UserAccount::userHas(['ACADEMIC'])){ 
            $exclude=array_column(\common\models\AssignedModule::find()->all(),'course_id');
            $all_modules=\common\models\AssignedModule::find()->where(['staff_id'=>Yii::$app->user->identity->user_id])->andWhere(['semester_id'=>$active_semester])->all();
            $include=array_column(\common\models\AssignedModule::find()->where(['semester_id'=>$active_semester,'staff_id'=>Yii::$app->user->identity->user_id])->andWhere(['academic_year_id'=>$active_year])->asArray()->all(),'course_id');
            $include_module=array_column(\common\models\AssignedModule::find()->where(['semester_id'=>$active_semester,'staff_id'=>Yii::$app->user->identity->user_id])->andWhere(['academic_year_id'=>$active_year])->asArray()->all(),'module_id');
            $assigned_course=\common\models\Course::find()->where(['IN','id',$include])->all();
            $assigned_module=\common\models\Module::find()->where(['IN','id',$include_module])->all();
           }

            if(UserAccount::userHas(['ACADEMIC'])){
                $user_department=\common\models\Staff::find()->where(['id'=>Yii::$app->user->identity->user_id])->one()->department_id;
                $assigned_module=\common\models\Module::find()->where(['semester_id'=>$active_semester])->andWhere(['department_id'=>$user_department])->all();
                $assigned_course=\common\models\Course::find()->where(['department_id'=>$user_department])->all();

            }

            ?>

            <?= $form->field($model, 'course_id',['options'=>['class'=>'required']])->widget(\kartik\select2\Select2::classname(), [
                'data' => ArrayHelper::map($assigned_course,'id','course_name'),
                'language' => 'en',
                'options' => ['placeholder' => 'Select Course ...', 'multiple' => false,
                    'onchange' => '
                                            $.post( "index.php?r=assignment/listsmodule&id=' . '"+$(this).val(), function( data ) {
                                              $( "select#assignment-module_id" ).html( data );
                                              
                                            });'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>



            <?= $form->field($model, 'academic_year_id')->widget(\kartik\select2\Select2::className(), ['data'=>\yii\helpers\ArrayHelper::map(\common\models\AcademicYear::find()->where(['status'=>'Active'])->all(),'id','name'),  'options'=>['placeholder'=>'--Select--']]) ?>



            <?php
            if (!$model->isNewRecord){?>

                <?=  $form->field($model, 'score')->textInput() ?>
            <?php }
            ?>
        </div>
        <div class="col-md-4">





            <?= $form->field($model, 'module_id')->widget(\kartik\select2\Select2::className(),['data'=>[],

                'language' => 'en',
                'options' => ['placeholder' => 'Select Module ...', 'multiple' => false,
                    'onchange' => '
                                            $.post( "index.php?r=assignment/listsmethod&id=' . '"+$(this).val(), function( data ) {
                                              $( "select#assignment-assessment_method_id" ).html( data );
                                              
                                            });'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],]) ?>
            <?= $form->field($model, 'semester_id')->widget(\kartik\select2\Select2::className(), ['data'=>\yii\helpers\ArrayHelper::map(\common\models\Semester::find()->where(['status'=>'Active'])->all(),'id','name'),'options'=>['placeholder'=>'--Select Year--']]) ?>



        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'assessment_method_id',['options'=>['class'=>'required']])->widget(\kartik\select2\Select2::classname(), [
                'data' => [],
                'language' => 'en',
                'options' => ['placeholder' => 'Select Method ...', 'multiple' => false],
                'pluginOptions' => [
                    'allowClear' => true
                ],

            ]);
            ?>
            <?php if($model->isNewRecord){?>

                <?= $form->field($model, 'csv_file')->fileInput()->label('Browse CSV File')?>
            <?php }?>




        </div>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord?'<span class="fa fa-cloud-upload">Upload Results</span>':'<span class="fa fa-pencil-square-o">Save Changes</span>', ['class' => 'btn btn-success pull-right',
                'data'=>['confirm'=>'Are you sure you want to Upload this Results?',
                    'method'=>'post']]) ?>
        </div>
    </fieldset>
    <?php ActiveForm::end(); ?>

</div>
