<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\FinalExam */

$this->title = 'Create Final Exam';
$this->params['breadcrumbs'][] = ['label' => 'Final Exams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="final-exam-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
