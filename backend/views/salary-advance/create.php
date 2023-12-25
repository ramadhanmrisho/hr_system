<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SalaryAdvance */

$this->title = ' Salary Advance Details';
$this->params['breadcrumbs'][] = ['label' => 'Salary Advances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="salary-advance-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
