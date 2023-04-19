<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StaffSessions */

$this->title = 'Update Staff Sessions: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Staff Sessions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="staff-sessions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
