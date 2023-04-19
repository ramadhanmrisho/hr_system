<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Staff */

$this->title = 'New Staff Details';
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
if(Yii::$app->session->hasFlash('getDanger')):?>
    <div class="alert alert-sm alert-danger zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getDanger');?>
    </div>
<?php endif;?>



<div class="staff-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
