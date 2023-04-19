<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FinalExam */

$this->title = 'Update Final Exam Score For: ' . $model->student->fname.' '.$model->student->lname;
$this->params['breadcrumbs'][] = ['label' => 'Final Exams', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="assignment-index">
    <?php
    \yiister\adminlte\widgets\Box::begin(
        [
            "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
        ]
    )
    ?>
<div class="final-exam-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
