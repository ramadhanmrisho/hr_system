<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OvertimeAmount */

$this->title = 'Update Overtime Amount';
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="overtime-amount-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
