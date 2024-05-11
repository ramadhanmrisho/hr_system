<?php

use yii\helpers\Html;
use kartik\time\TimePicker;


/* @var $this yii\web\View */
/* @var $model common\models\Attendance */

$this->title = 'Add Individual Attendance';
$this->params['breadcrumbs'][] = ['label' => 'Attendances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
if(Yii::$app->session->hasFlash('getError')):?>
    <div class="alert alert-sm alert-danger zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getError');?>
    </div>
<?php endif;?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="attendance-create">


    <?= $this->render('_forms', [
        'model' => $model,
    ]) ?>

</div>
