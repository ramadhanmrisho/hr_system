<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Coursework */

$this->title = 'Create Coursework';
$this->params['breadcrumbs'][] = ['label' => 'Courseworks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coursework-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
