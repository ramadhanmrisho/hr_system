<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StaffAllowance */

$this->title = 'Update Staff Allowance: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Staff Allowances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="staff-allowance-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
