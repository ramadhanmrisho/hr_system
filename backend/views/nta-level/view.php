<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\NtaLevel */

$this->title = 'NTA Level:'.$model->name;
$this->params['breadcrumbs'][] = ['label' => 'Nta Levels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="nta-level-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',

            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>
    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>

</div>
