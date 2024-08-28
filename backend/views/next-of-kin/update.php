<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\NextOfKin $model */

$this->title = 'Update Next Of Kin: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Next Of Kins', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="next-of-kin-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
