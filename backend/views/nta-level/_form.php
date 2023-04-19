<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\NtaLevel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nta-level-form">
<fieldset>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
            <?= Html::submitButton(($model->isNewRecord) ? 'Save ' : 'Save Changes', ['class' => 'btn btn-success btn-fill','style'=>'min-width:90px;']) ?>


        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>

    </div>
    <?php ActiveForm::end(); ?>
</fieldset>
