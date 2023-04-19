<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StudentFinancialCategory */

$this->title = 'Update Student Financial Category: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Student Financial Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="student-financial-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
