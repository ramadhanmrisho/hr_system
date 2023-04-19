<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ModuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Modules';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="module-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Module', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'module_name',
            'module_code',
            'course_id',
            'year_of_study_id',
            //'nta_level',
            //'prerequisite',
            //'semester_id',
            //'lect_hrs_per_week',
            //'tut_hrs_per_week',
            //'practical_hrs_per_week',
            //'class_practical_on_ca',
            //'ppb',
            //'final_practical',
            //'portifolio',
            //'delivery_book',
            //'proposal_report',
            //'category',
            //'module_credit',
            //'contact_hours',
            //'noncontact_hours',
            //'academic_year_id',
            //'created_by',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
