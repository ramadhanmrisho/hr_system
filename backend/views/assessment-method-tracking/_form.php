<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AssessmentMethodTracking */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="assessment-method-tracking-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'module_id')->textInput() ?>

    <?= $form->field($model, 'assessment_method_id')->textInput() ?>

    <?= $form->field($model, 'category')->dropDownList([ 'SE' => 'SE', 'CA' => 'CA', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'percent')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
