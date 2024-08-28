<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StaffSessions */
/* @var $searchModel common\models\search\PayrollTransactionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Filter Salary Sheet';
$this->params['breadcrumbs'][] = ['label' => 'Staff Sessions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-sessions-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


</div>
