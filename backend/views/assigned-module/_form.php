<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AssignedModule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="assigned-module-form">

    <?php $form = ActiveForm::begin(); ?>

    <fieldset>
        <div class="col-md-4">

            <?= $form->field($model, 'staff_id')->widget(\kartik\select2\Select2::className(),  ['data'=>\yii\helpers\ArrayHelper::map(\common\models\Staff::find()->where(['category'=>'Academic Staff'])->all(),'id','FullName'),'options'=>['placeholder'=>'--Select Instructor--']]) ?>

        </div>
        <?php if ($model->isNewRecord){?>
        <div class="col-md-4">
            <?php
            $active_semester=\common\models\Semester::find()->where(['status'=>'Active'])->one()->id;
            $active_year=\common\models\AcademicYear::find()->where(['status'=>'Active'])->one()->id;
            $hod_department_id=\common\models\Staff::find()->where(['id'=>Yii::$app->user->identity->user_id])->one()->department_id;

            $exclude=array_column(\common\models\AssignedModule::find()->where(['semester_id'=>$active_semester])->andWhere(['academic_year_id'=>$active_year])->asArray()->all(),'module_id');
            $all_modules=\common\models\Module::find()->where(['NOT IN','id',$exclude])->andWhere(['department_id'=>$hod_department_id,'semester_id'=>$active_semester])->all();
            ?>
        <?= $form->field($model, 'module_id')->widget(\kartik\select2\Select2::className(),['data'=>\yii\helpers\ArrayHelper::map($all_modules,'id','module_name'),'options'=>['placeholder'=>'--Select Module--']]) ?>
        </div>
        <div class="col-md-4">
            <?php   $active_year=\common\models\AcademicYear::find()->where(['status'=>'Active'])->one()->id?>
        <?= $form->field($model, 'academic_year_id')->widget(\kartik\select2\Select2::className(),['data'=>\yii\helpers\ArrayHelper::map(\common\models\AcademicYear::find()->where(['id'=>$active_year])->all(),'id','name'),'options'=>['placeholder'=>'--Select Academic Year--']]) ?>
        </div>
<?php }?>
    </fieldset>
    <div class="form-group" align="center">
        <?= Html::submitButton($model->isNewRecord?'Save Details':'Save Changes', ['class' => 'btn btn-success','style'=>'min-width:150px',
            'data'=>[
                    'confirm'=>'Are you sure you want to assign this Module to this Staff',
                'method'=>'post'
            ]]) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
