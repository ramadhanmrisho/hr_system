<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\GpaClass */

$this->title = 'Create Gpa Class';
$this->params['breadcrumbs'][] = ['label' => 'Gpa Classes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gpa-class-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
