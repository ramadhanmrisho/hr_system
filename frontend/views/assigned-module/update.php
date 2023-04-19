<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AssignedModule */

$this->title = 'Update Assigned Module: ' . $model->module_id;
$this->params['breadcrumbs'][] = ['label' => 'Assigned Modules', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->module_id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="assigned-module-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
