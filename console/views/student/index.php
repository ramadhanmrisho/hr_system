<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Students';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Student', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fname',
            'mname',
            'lname',
            'dob',
            //'place_of_birth',
            //'phone_number',
            //'identity_type_id',
            //'id_number',
            //'marital_status',
            //'email:email',
            //'gender',
            //'passport_size',
            //'registration_number',
            //'nationality_id',
            //'region_id',
            //'district_id',
            //'village',
            //'academic_year_id',
            //'home_address',
            //'course_id',
            //'year_of_study_id',
            //'sponsorship',
            //'status',
            //'date_of_admission',
            //'college_residence',
            //'department_id',
            //'intake_type',
            //'created_by',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
