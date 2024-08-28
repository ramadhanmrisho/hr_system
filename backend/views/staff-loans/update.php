<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\StaffLoans $model */

$this->title = 'Update Staff Loans: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Staff Loans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="staff-loans-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
