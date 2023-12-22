<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PayrollTransactions */

$this->title = 'Update Payroll Transactions: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Payroll Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="payroll-transactions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
