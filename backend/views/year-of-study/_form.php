<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\YearOfStudy */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="year-of-study-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal" >Cancel</button>


    </div>

    <?php ActiveForm::end(); ?>

</div>
