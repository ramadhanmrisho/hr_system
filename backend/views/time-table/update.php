<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TimeTable */

$this->title = 'Update Time Table:';
$this->params['breadcrumbs'][] = ['label' => 'Time Tables', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="time-table-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
