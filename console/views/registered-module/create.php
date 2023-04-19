<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\RegisteredModule */

$this->title = 'Create Registered Module';
$this->params['breadcrumbs'][] = ['label' => 'Registered Modules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registered-module-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
