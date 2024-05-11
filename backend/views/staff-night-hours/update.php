<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StaffNightHours */

$this->title = 'Update Staff Night Hours: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Staff Night Hours', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="staff-night-hours-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
