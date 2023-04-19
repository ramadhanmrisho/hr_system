<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Module */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Modules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="module-view">

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
            'module_name',
            'module_code',
            'course_id',
           ['attribute':'year_of_study_id','value':'yearOfStudy.name']
            'nta_level',
            'prerequisite',
           ['attribute':'semester_id','value':'semester.name']
            'lect_hrs_per_week',
            'tut_hrs_per_week',
            'practical_hrs_per_week',
            'class_practical_on_ca',
            'ppb',
            'final_practical',
            'portifolio',
            'delivery_book',
            'proposal_report',
            'category',
            'module_credit',
            'contact_hours',
            'noncontact_hours',
           ['attribute':'academic_year_id','value':'academicYear.name']
            'createdBy.fullName',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
