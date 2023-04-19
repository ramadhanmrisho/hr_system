<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AssignedModule */

$this->title = ' Staff Assigned Module';
$this->params['breadcrumbs'][] = ['label' => 'Staff  Assigned Modules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="assigned-module-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
