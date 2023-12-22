<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SalaryAdjustments */

$this->title = 'Salary Adjustments Details';
$this->params['breadcrumbs'][] = ['label' => 'Salary Adjustments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="salary-adjustments-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
