<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\StudentFinancialCategory */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Student Financial Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-financial-category-view">

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
            'student_id',
            'category',
           ['attribute':'academic_year_id','value':'academicYear.name']
            'year_of_study',
            'createdBy.fullName',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
