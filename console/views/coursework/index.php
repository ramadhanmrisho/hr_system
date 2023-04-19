<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CourseworkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Courseworks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coursework-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Coursework', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'student_id',
            'module_id',
            'test_1',
            'test_2',
            //'assignment_1',
            //'assignment_2',
            //'class_practical',
            //'final_practical',
            //'ppb',
            //'portifolio',
            //'total_score',
            //'academic_year_id',
            //'year_of_study_id',
            //'course_id',
            //'semester_id',
            //'created_at',
            //'staff_id',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
