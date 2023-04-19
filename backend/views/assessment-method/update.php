<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AssessmentMethod */

$this->title = 'Update Assessment Method: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Assessment Methods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="assessment-method-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
