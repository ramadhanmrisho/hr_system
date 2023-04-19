<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\GpaClass */

$this->title = 'Create Gpa Class';
$this->params['breadcrumbs'][] = ['label' => 'Gpa Classes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="gpa-class-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
