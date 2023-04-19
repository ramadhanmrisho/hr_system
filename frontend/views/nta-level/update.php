<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\NtaLevel */

$this->title = 'Update Nta Level: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Nta Levels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="nta-level-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
