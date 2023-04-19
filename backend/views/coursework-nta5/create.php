<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CourseworkNta5 */

$this->title = 'Fill the form to View Courseworks';
$this->params['breadcrumbs'][] = ['label' => 'Coursework NTA 5', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
if(Yii::$app->session->hasFlash('getDanger')):?>
    <div class="alert alert-sm alert-danger zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getDanger');?>
    </div>
<?php endif;?>
<div class="coursework-nta6-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
