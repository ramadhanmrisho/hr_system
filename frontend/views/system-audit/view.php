<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SystemAudit */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'System Audits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-audit-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'session_id',
            'item_class',
            'item_id',
            'action',
            'description',
            'extra:ntext',
            'createdBy.fullName',
            'created_at:datetime',
        ],
    ]) ?>

</div>
