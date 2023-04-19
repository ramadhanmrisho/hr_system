<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\NtaLevel */

$this->title = 'Create Nta Level';
$this->params['breadcrumbs'][] = ['label' => 'Nta Levels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nta-level-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
