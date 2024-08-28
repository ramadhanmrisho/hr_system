<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\StaffLoans $model */

$this->title = 'Staff Loan Details';
$this->params['breadcrumbs'][] = ['label' => 'Staff Loans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<?php
if(Yii::$app->session->hasFlash('getDanger')):?>
    <div class="alert alert-sm alert-danger zoomIn" align="center">
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
<div class="staff-loans-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
