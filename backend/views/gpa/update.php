<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Gpa */

$this->title = 'Update Gpa: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gpas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gpa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
