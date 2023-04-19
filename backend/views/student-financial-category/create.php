<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StudentFinancialCategory */

$this->title = 'Create Student Financial Category';
$this->params['breadcrumbs'][] = ['label' => 'Student Financial Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-financial-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
