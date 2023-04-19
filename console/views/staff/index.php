<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\StaffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Staff';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Staff', ['create'], ['class' => 'btn btn-success']) ?>
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
            //'employee_number',
            //'category',
            //'region_id',
            //'district_id',
            //'ward',
            //'village',
            //'division',
            //'home_address',
            //'house_number',
            //'name_of_high_education_level',
            //'designation_id',
            //'department_id',
            //'salary_scale',
            //'basic_salary',
            //'allowance_id',
            //'helsb',
            //'paye',
            //'nssf',
            //'nhif',
            //'date_employed',
            //'account_name',
            //'bank_account_number',
            //'alternate_phone_number',
            //'created_by',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
