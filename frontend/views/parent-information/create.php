<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ParentInformation */

$this->title = 'Create Parent Information';
$this->params['breadcrumbs'][] = ['label' => 'Parent Informations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parent-information-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
