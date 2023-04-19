<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CourseworkNta5 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Coursework Nta5s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="coursework-nta5-view">

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
            'module_id',
            'cat_1',
            'cat_2',
            'assignment_1',
            'assignment_2',
            'practical',
            'ppb',
            'practical_2',
            'total_score',
            'remarks',
            'academic_year_id',
            'year_of_study_id',
            'course_id',
            'semester_id',
            'created_at',
            'staff_id',
            'updated_at',
        ],
    ]) ?>

</div>
