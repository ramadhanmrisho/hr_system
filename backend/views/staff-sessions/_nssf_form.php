<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\StaffSessions */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="staff-sessions-form">

    <?php $form = ActiveForm::begin(); ?>


    <?php
    // Array for months
    $months = [
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December',
    ];

    $years = [];
    for ($i = 2024; $i <= 2030; $i++) {
        $years[$i] = $i;
    } ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'month')->dropDownList($months, ['prompt' => 'Select Month']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'year')->dropDownList($years, ['prompt' => 'Select Year']) ?>
        </div>
    </div>
    <br>
    <div class="form-group" align="center">
        <?= Html::submitButton('View Report', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>


