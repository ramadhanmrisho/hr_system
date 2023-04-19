<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ExamResultSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Exam Results';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exam-result-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Exam Result', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'student_id',
            'academic_year_id',
            'year_of_study_id',
            'course_id',
            //'semester_id',
            //'coursework_id',
            //'final_exam_id',
            //'module_id',
            //'total_score',
            //'category',
            //'status',
            //'created_at',
            //'created_by',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
