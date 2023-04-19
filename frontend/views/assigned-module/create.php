<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AssignedModule */

$this->title = 'Create Assigned Module';
$this->params['breadcrumbs'][] = ['label' => 'Assigned Modules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assigned-module-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
