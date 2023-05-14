<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Dependants */

$this->title = 'Update Dependants: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Dependants', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dependants-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
