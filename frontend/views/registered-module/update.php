<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RegisteredModule */

$this->title = 'Update Registered Module: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Registered Modules', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="registered-module-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
