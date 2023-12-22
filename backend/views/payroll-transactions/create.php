<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PayrollTransactions */

$this->title = 'Create Payroll Transactions';
$this->params['breadcrumbs'][] = ['label' => 'Payroll Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payroll-transactions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
