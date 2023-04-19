<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ALevelGradeScore */

$this->title = 'Update A Level Grade Score: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'A Level Grade Scores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="alevel-grade-score-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
