<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Module */

$this->title = 'Module Registration';
$this->params['breadcrumbs'][] = ['label' => 'Modules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
if(Yii::$app->session->hasFlash('getDanger')):?>
    <div class="alert alert-sm alert-warning" align="center">
        <?= Yii::$app->session->getFlash('getDanger');?>
    </div>
<?php endif;?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="module-create"
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
