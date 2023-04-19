<?php

use fedemotta\datatables\DataTables;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="student-index">

    <?php Pjax::begin(); ?>


    <?= DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
             ['attribute'=>'student_id','value'=>function($model){
                return $model->fname.' '.$model->lname;},'label'=>'Student Name'],
            'registration_number',
            'dob',
            'place_of_birth',
            'phone_number',
            //'identity_type_id',
            //'id_number',
            //'marital_status',
            'email:email',
            //'gender',
            //'passport_size',

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

            ['class' => 'yii\grid\ActionColumn',

                'template'=>'{view}',
                'contentOptions' => ['style' => 'width:100px;'],
                'header'=>"ACTION",
                'headerOptions' => [
                    'style' => 'color:red'
                ],
                'buttons' => [


                    //view button
                    'view' => function ($url, $model) {
                        return Html::a('<span class="fa fa-open-eye"></span>View More', $url, [
                            'title' => Yii::t('app', 'View'),
                            'class'=>'btn btn-primary btn-xs',]);


                    },

                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'view') {
                            $url = 'index.php?r=student/view&id='.$model->id;
                            return $url;
                        }

                    } ,

                ],

            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
