<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SalaryAdvance */

$this->title = 'Update Salary Advance: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Salary Advances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="salary-advance-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
