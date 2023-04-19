<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OLevelInformation */

$this->title = 'Create O Level Information';
$this->params['breadcrumbs'][] = ['label' => 'O Level Informations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="olevel-information-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
