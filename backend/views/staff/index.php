<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\StaffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Staff';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
if(Yii::$app->session->hasFlash('getSuccessgetSuccess')):?>
    <div class="alert alert-sm alert-success zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getSuccess');?>
    </div>
<?php endif;?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="staff-index">


    <?php Pjax::begin(); ?>

    <?php if (\common\models\UserAccount::userHas(['HR','ADMIN'])){?>
    <p>
        <?= Html::a('<span class="fa fa-user-plus"></span> Add New Staff', ['create'], ['class' => 'btn btn-success ']) ?>
    </p>
<?php }?>
    <?= DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,'clientOptions' => [
            "lengthMenu"=> [[20,-1], [20,Yii::t('app',"All")]],
            "info"=>false,
            "responsive"=>true,
            "dom"=> 'lfTrtip',
            "tableTools"=>[
                "aButtons"=> [
                    [
                        "sExtends"=> "copy",
                        "sButtonText"=> Yii::t('app',"Copy to clipboard")
                    ],[
                        "sExtends"=> "csv",
                        "sButtonText"=> Yii::t('app',"Save to CSV")
                    ],[
                        "sExtends"=> "xls",
                        "oSelectorOpts"=> ["page"=> 'current']
                    ],[
                        "sExtends"=> "pdf",
                        "sButtonText"=> Yii::t('app',"Save to PDF")
                    ],[
                        "sExtends"=> "print",
                        "sButtonText"=> Yii::t('app',"Print")
                    ],
                ]
            ]
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'fname',
            'lname',
         
            'phone_number',
             ['attribute'=> 'designation_id','value'=>function($model){

            return $model->designation->name;
            }],
         
            'gender',
            'employee_number',
            'category',
//            'region_id',
//            'district_id',
//            'ward',
//            'village',
//            'division',
//            'home_address',
            //'house_number',
            //'name_of_high_education_level',
          
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
                            $url = 'index.php?r=staff/view&id='.$model->id;
                            return $url;
                        }

                    } ,


                ],






            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
