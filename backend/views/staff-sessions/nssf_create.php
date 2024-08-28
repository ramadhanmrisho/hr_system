<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StaffSessions */
/* @var $searchModel common\models\search\PayrollTransactionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Filter by Month and Year';
$this->params['breadcrumbs'][] = ['label' => 'Staff Sessions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-sessions-create">

    <?= $this->render('_nssf_form', [
        'model' => $model,
    ]) ?>
</div>
