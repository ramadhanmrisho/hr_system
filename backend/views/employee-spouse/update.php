<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\EmployeeSpouse $model */

$this->title = 'Update Employee Spouse: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Employee Spouses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="employee-spouse-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
