<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TimeTable */

$this->title = 'Upload Time Table';
$this->params['breadcrumbs'][] = ['label' => 'Time Tables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="time-table-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
