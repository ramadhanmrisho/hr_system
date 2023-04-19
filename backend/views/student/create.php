<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Student */

//$this->title = 'STUDENT REGISTRATION FORM';
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' =>'#'];
$this->params['breadcrumbs'][] = $this->title;
?>
<br>
<?php
if(Yii::$app->session->hasFlash('reqDanger')):?>
    <div class="alert alert-sm alert-danger zoomIn" align="center">
        <?= Yii::$app->session->getFlash('reqDanger');?>
    </div>
<?php endif;?>
<h2 class="btn btn-primary"  style="font-family:'Tahoma'" >STUDENT REGISTRATION FORM</h2>

<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="student-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php \yiister\adminlte\widgets\Box::end() ?>
