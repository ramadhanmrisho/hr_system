<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GeneratedResult */

$this->title = 'Fill the form to view results';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
if(Yii::$app->session->hasFlash('getDanger')):?>
    <div class="alert alert-sm alert-danger zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getDanger');?>
    </div>
<?php endif;?>

<div class="generated-result-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
