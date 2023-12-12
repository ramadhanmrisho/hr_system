<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DeductionsPercentage */

$this->title = 'Update Deductions Percentage: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="deductions-percentage-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
