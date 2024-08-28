<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\EmployeeSpouse $model */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Employee Spouses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-spouse-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
