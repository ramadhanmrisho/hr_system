<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ALevelInformation */

$this->title = 'Update A Level Information Of ' . $model->student->fname.' '.$model->student->lname;
$this->params['breadcrumbs'][] = ['label' => 'Go to Student Information', 'url' => ['student/view', 'id' => $model->student_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="student-index">
    <?php
    \yiister\adminlte\widgets\Box::begin(
        [
            "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
        ]
    )
    ?>
<div class="alevel-information-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
