<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\NtaLevel */

$this->title = 'NTA Level';
$this->params['breadcrumbs'][] = ['label' => 'Nta Levels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nta-level-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
