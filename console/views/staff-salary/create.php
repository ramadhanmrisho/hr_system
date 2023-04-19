<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StaffSalary */

$this->title = 'Create Staff Salary';
$this->params['breadcrumbs'][] = ['label' => 'Staff Salaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-salary-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
