<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ParentInformation */

$this->title = 'Update Parent Information of  ' . $model->student->registration_number;
$this->params['breadcrumbs'][] = ['label' => ' Go to Student Information','url'=>['student/view','id'=>$model->student->id]];
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="parent-information-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
