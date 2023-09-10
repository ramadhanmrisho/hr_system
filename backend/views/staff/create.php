<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Staff */

//$this->title = 'New Employee Details';
$this->params['breadcrumbs'][] = ['label' => 'Employee List', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
if(Yii::$app->session->hasFlash('getDanger')):?>
    <div class="alert alert-sm alert-danger zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getDanger');?>
    </div>
<?php endif;?>

<h3 style="font-family: Lucida Bright"> <?= 'New Employee Details'?></h3>


<div class="staff-create" style="font-family:Lucida Bright">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
