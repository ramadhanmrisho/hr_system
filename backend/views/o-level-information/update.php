<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OLevelInformation */

$this->title = 'Update O Level Information: ' . $model->student->registration_number;

$this->params['breadcrumbs'][] = ['label' => 'Go to Student Information', 'url' => ['student/view', 'id' => $model->student_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="olevel-information-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
