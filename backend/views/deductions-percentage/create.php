<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DeductionsPercentage */

$this->title = 'Deductions Percentage';
$this->params['breadcrumbs'][] = ['label' => 'Deductions Percentages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="deductions-percentage-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
