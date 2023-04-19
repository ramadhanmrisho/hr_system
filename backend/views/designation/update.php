<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Designation */

$this->title = 'Update Designation: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Designations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="designation-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
