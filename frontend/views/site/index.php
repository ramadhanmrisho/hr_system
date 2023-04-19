<?php

/* @var $this yii\web\View */


?>
<?php
if(Yii::$app->session->hasFlash('reqSuccess')):?>
    <div class="alert alert-sm alert-success zoomIn" align="center">
        <?= Yii::$app->session->getFlash('reqSuccess');?>
    </div>
<?php endif;?>
<?php
if(Yii::$app->session->hasFlash('reqDanger')):?>
    <div class="alert alert-sm alert-danger zoomIn" align="center">
        <?= Yii::$app->session->getFlash('reqDanger');?>
    </div>
<?php endif;?>


