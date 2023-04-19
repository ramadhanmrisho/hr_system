<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CourseworkNta4 */

$this->title = 'Fill the form to View Courseworks';
$this->params['breadcrumbs'][] = ['label' => 'Coursework Nta4s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
if(Yii::$app->session->hasFlash('getDanger')):?>
    <div class="alert alert-sm alert-danger zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getDanger');?>
    </div>
<?php endif;?>
<div class="coursework-nta4-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
