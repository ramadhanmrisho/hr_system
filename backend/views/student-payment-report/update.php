<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StudentPaymentReport */

$this->title = 'Update Student Payment Report: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Student Payment Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="student-payment-report-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
