<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\OLevelGradeScore */

$this->title = 'Create O Level Grade Score';
$this->params['breadcrumbs'][] = ['label' => 'O Level Grade Scores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="olevel-grade-score-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
