<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\GpaClass */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gpa Classes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gpa-class-view">

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
            'starting_point',
            'end_point',
            'gpa_class',
           ['attribute':'year_of_study_id','value':'yearOfStudy.name']
           ['attribute':'academic_year_id','value':'academicYear.name']
            'course_id',
            'createdBy.fullName',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
