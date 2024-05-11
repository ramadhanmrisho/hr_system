<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StaffNightHours */

$this->title = 'Staff Night Hours';
$this->params['breadcrumbs'][] = ['label' => 'Staff Night Hours', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="staff-night-hours-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
