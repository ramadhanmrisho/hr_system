<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Roster */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>

<div class="roster-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'working_days')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'working_hours')->textInput() ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
