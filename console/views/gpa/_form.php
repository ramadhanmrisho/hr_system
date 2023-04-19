<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Gpa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gpa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'student_id')->textInput() ?>

    <?= $form->field($model, 'academic_year_id')->widget(\kartik\select2\Select2::className(),             ['data'=>\yii\helpers\ArrayHelper::map(\common\models\AcademicYear::find()->all(),'id','name'),             'options'=>['placeholder'=>'--Select--']]) ?>

    <?= $form->field($model, 'exam_result_id')->textInput() ?>

    <?= $form->field($model, 'semester_id')->widget(\kartik\select2\Select2::className(),             ['data'=>\yii\helpers\ArrayHelper::map(\common\models\Semester::find()->all(),'id','name'),             'options'=>['placeholder'=>'--Select--']]) ?>

    <?= $form->field($model, 'gpa')->textInput() ?>

    <?= $form->field($model, 'gpa_class_id')->textInput() ?>

    <?= $form->field($model, 'remark')->dropDownList([ 'Best Student' => 'Best Student', 'Second Student' => 'Second Student', 'Third Student' => 'Third Student', 'Normal' => 'Normal', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
