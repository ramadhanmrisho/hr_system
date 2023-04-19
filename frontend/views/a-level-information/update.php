<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ALevelInformation */

$this->title = 'Update A Level Information: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'A Level Informations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="alevel-information-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
