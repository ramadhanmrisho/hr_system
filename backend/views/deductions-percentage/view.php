<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\DeductionsPercentage */

$this->title ='General Deductions';
$this->params['breadcrumbs'][] = ['label' => 'Deductions Percentages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="deductions-percentage-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'NSSF',
            'WCF',
            'SDL',
            'NHIF',
            'created_at',
            'updated_at',
            'status',
            'created_by',
        ],
    ]) ?>

</div>
