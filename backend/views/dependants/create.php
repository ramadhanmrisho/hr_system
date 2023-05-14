<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Dependants */

$this->title = 'Create Dependants';
$this->params['breadcrumbs'][] = ['label' => 'Dependants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dependants-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
