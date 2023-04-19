<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OlevelAndAlevelSubject */

$this->title = 'Update Olevel And Alevel Subject: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Olevel And Alevel Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="olevel-and-alevel-subject-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
