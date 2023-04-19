<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ParentInformation */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Parent Informations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parent-information-view">

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
            'fname',
            'mname',
            'lname',
            'phone_number',
            'email:email',
            'gender',
           ['attribute':'nationality_id','value':'nationality.name']
            'relationship',
            'occupation',
            'physical_address',
            'student_id',
            'createdBy.fullName',
            'created_at:datetime',
            'updated_at:datetime',
            'altenate_phone_number',
        ],
    ]) ?>

</div>
