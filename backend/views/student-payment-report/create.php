<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StudentPaymentReport */

$this->title = ' Student Payment Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
if(Yii::$app->session->hasFlash('getSuccess')):?>
    <div class="alert alert-sm alert-success zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getSuccess');?>
    </div>
<?php endif;?>
<?php
if(Yii::$app->session->hasFlash('getDanger')):?>
    <div class="alert alert-sm alert-danger zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getDanger');?>
    </div>
<?php endif;?>
<div class="student-payment-report-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
