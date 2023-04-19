<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Grade */

$this->title = 'Create Grade';
$this->params['breadcrumbs'][] = ['label' => 'Grades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="grade-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
