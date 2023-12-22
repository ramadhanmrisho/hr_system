<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Roster */

$this->title = 'Update Roster: ';
$this->params['breadcrumbs'][] = ['label' => 'Rosters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="roster-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
