<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Attendance */

$this->title = 'Upload  Attendance';
$this->params['breadcrumbs'][] = ['label' => 'Attendances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="attendance-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
