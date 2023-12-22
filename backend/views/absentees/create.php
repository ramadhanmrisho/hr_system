<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Absentees */

$this->title = 'Details';
$this->params['breadcrumbs'][] = ['label' => 'Back', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="absentees-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
