<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TimeTable */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="time-table-form">

<?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'course_id')->widget(\kartik\select2\Select2::className(),['data'=>\yii\helpers\ArrayHelper::map(\common\models\Course::find()->all(),'id','course_name'), 'options'=>['placeholder'=>'--Select--']]) ?>
            </div>
            <div class="col-md-6">

                    <?= $form->field($model, 'time_table',['options'=>['class'=>'required']])->widget(\kartik\file\FileInput::className(),[
                        'options' => ['accept'=>'*', 'required' => true],
                        'pluginOptions' => ['allowedFileExtensions' => ['pdf'], 'showUpload' => false]
                    ]); ?>
            </div>


        </div>

    <div class="form-group" align="center">
        <?= Html::submitButton('<span class="fa fa-cloud-upload"> Upload </span>', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
