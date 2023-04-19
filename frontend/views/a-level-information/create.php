<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ALevelInformation */

$this->title = 'Create A Level Information';
$this->params['breadcrumbs'][] = ['label' => 'A Level Informations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alevel-information-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
