<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Supplementary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="final-exam-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
    <fieldset>

        <div class="col-md-4">
            <?php

            $active_semester=\common\models\Semester::find()->where(['status'=>'Active'])->one()->id;
            $active_year=\common\models\AcademicYear::find()->where(['status'=>'Active'])->one()->id;
            $exclude=array_column(\common\models\AssignedModule::find()->all(),'course_id');
            $all_modules=\common\models\AssignedModule::find()->where(['staff_id'=>Yii::$app->user->identity->user_id])->andWhere(['semester_id'=>$active_semester])->all();
            $include=array_column(\common\models\AssignedModule::find()->where(['semester_id'=>$active_semester,'staff_id'=>Yii::$app->user->identity->user_id])->andWhere(['academic_year_id'=>$active_year])->asArray()->all(),'course_id');
            $include_module=array_column(\common\models\AssignedModule::find()->where(['semester_id'=>$active_semester,'staff_id'=>Yii::$app->user->identity->user_id])->andWhere(['academic_year_id'=>$active_year])->asArray()->all(),'module_id');
            $assigned_course=\common\models\Course::find()->where(['IN','id',$include])->all();
            $assigned_module=\common\models\Module::find()->where(['IN','id',$include_module])->all();
            ?>
            <?= $form->field($model, 'course_id')->widget(\kartik\select2\Select2::className(),['data'=>\yii\helpers\ArrayHelper::map($assigned_course,'id','course_name'),'options'=>['placeholder'=>'--Select Course--']]) ?>
            <?= $form->field($model, 'module_id')->widget(\kartik\select2\Select2::className(),['data'=>\yii\helpers\ArrayHelper::map($assigned_module,'id','module_name'),'options'=>['placeholder'=>'--Select Module--']]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'year_of_study_id')->widget(\kartik\select2\Select2::className(),['data'=>\yii\helpers\ArrayHelper::map(\common\models\YearOfStudy::find()->all(),'id','name'), 'options'=>['placeholder'=>'--Select--']]) ?>
            <?= $form->field($model, 'semester_id')->widget(\kartik\select2\Select2::className(), ['data'=>\yii\helpers\ArrayHelper::map(\common\models\Semester::find()->where(['status'=>'Active'])->all(),'id','name'),'options'=>['placeholder'=>'--Select Year--']]) ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'academic_year_id')->widget(\kartik\select2\Select2::className(), ['data'=>\yii\helpers\ArrayHelper::map(\common\models\AcademicYear::find()->all(),'id','name'),  'options'=>['placeholder'=>'--Select Academic Year--']]) ?>

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
