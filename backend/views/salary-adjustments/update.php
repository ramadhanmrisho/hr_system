<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SalaryAdjustments */

$this->title = 'Update Salary Adjustment For : ' .\common\models\Staff::findOne([ $model->staff_id])->fname;
$this->params['breadcrumbs'][] = ['label' => 'Salary Adjustments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="salary-adjustments-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
