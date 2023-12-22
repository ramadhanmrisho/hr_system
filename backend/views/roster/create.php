<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Roster */

$this->title = ' Roster Details';
$this->params['breadcrumbs'][] = ['label' => 'Rosters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="roster-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
