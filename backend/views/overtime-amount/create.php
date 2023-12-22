<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OvertimeAmount */

$this->title = 'OT Amounts';
$this->params['breadcrumbs'][] = ['label' => 'Overtime Amounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="overtime-amount-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
