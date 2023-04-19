<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ALevelInformation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alevel-information-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name_of_school')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'index_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'student_id')->textInput() ?>

    <?= $form->field($model, 'division')->dropDownList([ 'I' => 'I', 'II' => 'II', 'III' => 'III', 'IV' => 'IV', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'a_level_certificate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'award')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
