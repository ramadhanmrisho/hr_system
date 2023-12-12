<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Attendance */

$this->title = 'Update Attendance: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Attendances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="attendance-update">



    <?= $this->render('_edit', [
        'model' => $model,
    ]) ?>

</div>
