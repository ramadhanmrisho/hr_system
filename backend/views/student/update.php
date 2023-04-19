<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Student */


$this->title = 'Update Student Details: ' . $model->fname.' '.$model->lname;
$this->params['breadcrumbs'][] = ['label' => 'Go to Student Information', 'url' => ['view', 'id' => $model->id]];
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
<div class="student-update">


    <?= $this->render('fom', [
        'model' => $model,
    ]) ?>

</div>
