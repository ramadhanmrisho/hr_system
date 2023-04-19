<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ALevelGradeScore */

$this->title = 'Create A Level Grade Score';
$this->params['breadcrumbs'][] = ['label' => 'A Level Grade Scores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alevel-grade-score-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
