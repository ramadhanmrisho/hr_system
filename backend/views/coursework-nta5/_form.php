<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CourseworkNta5 */
/* @var $form yii\widgets\ActiveForm */
?>
<style>

    form div.required label.control-label:after {

        content:" * ";

        color:red;

    }
</style>

<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>

<div class="nta5-form">

    <?php $form = ActiveForm::begin(); ?>

    <fieldset>
        <div class="col-md-4">
            <?= $form->field($model, 'course_id')->widget(\kartik\select2\Select2::className(),['data'=>\yii\helpers\ArrayHelper::map(\common\models\Course::find()->where(['nta_level'=>'5'])->all(),'id','course_name'),'options'=>['placeholder'=>'--Select Course--']]) ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'academic_year_id')->widget(\kartik\select2\Select2::className(), ['data'=>\yii\helpers\ArrayHelper::map(\common\models\AcademicYear::find()->all(),'id','name'),  'options'=>['placeholder'=>'--Select Academic Year--']]) ?>

        </div>

        <div class="col-md-4    ">

            <?= $form->field($model, 'semester_id')->widget(\kartik\select2\Select2::className(), ['data'=>\yii\helpers\ArrayHelper::map(\common\models\Semester::find()->all(),'id','name'),'options'=>['placeholder'=>'--Select Year--']]) ?>

        </div>

    </fieldset>
    <div class="form-group" align="center">
        <?= Html::submitButton('<span class="fa fa-edit"> View Courseworks</span>', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
