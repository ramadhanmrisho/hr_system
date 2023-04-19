<?php

use common\models\Module;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\FinalExam */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="final-exam-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
    <fieldset>

        <div class="col-md-4">
            <?php

            $active_semester=\common\models\Semester::find()->where(['status'=>'Active'])->one()->id;
            $active_year=\common\models\AcademicYear::find()->where(['status'=>'Active'])->one()->id;
            $user_department=\common\models\Staff::find()->where(['id'=>Yii::$app->user->identity->user_id])->one()->department_id;

            ?>

            <?= $form->field($model, 'course_id',['options'=>['class'=>'required']])->widget(\kartik\select2\Select2::classname(), [
                'data' => ArrayHelper::map(\common\models\Course::find()->where(['department_id'=>$user_department])->all(),'id','course_name'),
                'language' => 'en',
                'options' => ['placeholder' => 'Select Course ...', 'multiple' => false,
                    'onchange' => '
                                            $.post( "index.php?r=final-exam/listsmodule&id=' . '"+$(this).val(), function( data ) {
                                              $( "select#finalexam-module_id" ).html( data );
                                              
                                            });'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>


            <?= $form->field($model, 'nta_level')->dropDownList([ '4' => '4', '5' => '5', '6' => '6' ], ['prompt' => '']) ?>

        </div>
        <div class="col-md-4">

            <?= $form->field($model, 'module_id')->widget(\kartik\select2\Select2::className(),['data'=>[],

                'language' => 'en',
                'options' => ['placeholder' => 'Select Module ...', 'multiple' => false,

                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],]) ?>


            <?= $form->field($model, 'semester_id')->widget(\kartik\select2\Select2::className(), ['data'=> ArrayHelper::map(\common\models\Semester::find()->where(['status'=>'Active'])->all(),'id','name'),'options'=>['placeholder'=>'--Select Year--']]) ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'academic_year_id')->widget(\kartik\select2\Select2::className(), ['data'=> ArrayHelper::map(\common\models\AcademicYear::find()->where(['status'=>'Active'])->all(),'id','name'),  'options'=>['placeholder'=>'--Select Academic Year--']]) ?>

            <?php if($model->isNewRecord){?>

                <?= $form->field($model, 'csv_file')->fileInput()->label('Browse CSV File')?>
            <?php }
            if (!$model->isNewRecord){?>

                <?=  $form->field($model, 'practical')->textInput() ?>
                <?=  $form->field($model, 'written_exam')->textInput() ?>
            <?php }
            ?>

        </div>


    </fieldset>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord?'<span class="fa fa-cloud-upload">Upload Results</span>':'<span class="fa fa-pencil-square-o">Save Changes</span>', ['class' => 'btn btn-success pull-right',
            'data'=>['confirm'=>'Are you sure you want to Upload Final  Results',
                'method'=>'post']]) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
