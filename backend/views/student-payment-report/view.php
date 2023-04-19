<?php

use common\models\Course;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Payment */

$this->title =strtoupper(Course::findOne(['id'=>$model->course_id])->course_name.' Financial Report');

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



<div class="payment-view">



    <div>

        <?php
        $completePath = Yii::getAlias('@web/paylist/'.$model->file_name);
        // $completePath='/slips';
        $filename="Student Financial Report";


        echo $model->pdfViewer($completePath);

        ?>

    </div>

</div>
