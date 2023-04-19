<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\IdentityType */

$this->title = 'Update Identity Type: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Identity Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="identity-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
