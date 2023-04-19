<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CarryOver */

$this->title = 'Create Carry Over';
$this->params['breadcrumbs'][] = ['label' => 'Carry Overs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carry-over-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
