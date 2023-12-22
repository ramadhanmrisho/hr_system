<?php

use kartik\export\ExportMenu;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\StaffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employees List';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
if(Yii::$app->session->hasFlash('getSuccess')):?>
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
<div class="staff-index" style="font-family: Lucida Bright">


    <?php Pjax::begin(); ?>
    <?php if (\common\models\UserAccount::userHas(['HR','ADMIN'])){?>
    <p align="right">
        <?= Html::a('<span class="fa fa-user-plus"></span> Add New Employee', ['create'], ['class' => 'btn btn-success ']) ?>
    </p>
<?php }?>
    <?php
    $columns=[
        ['class' => 'yii\grid\SerialColumn'],
        'employee_number',
        ['attribute'=> 'fname','value'=>function($model){
            return $model->fname.' '.$model->mname.' '.$model->lname;
        },'label'=>'Full Name'],

        'phone_number',
        ['attribute'=> 'designation_id','value'=>function($model){

            return $model->designation->name;
        }],
        'gender',
        ['attribute'=> 'category','value'=>function($model){

            return $model->category;
        },'label'=>'Contract Category'],
        ['attribute'=>'basic_salary','value'=>function($model){

        return Yii::$app->formatter->asDecimal($model->basic_salary,2);

        }],
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
    ];

    echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columns,
        'clearBuffers' => false, //optional
        'export' => [
            ExportMenu::FORMAT_PDF,
            ExportMenu::FORMAT_CSV,
            ExportMenu::FORMAT_EXCEL,
        ],
    ]);
    ?>


    <?= DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,'clientOptions' => [
            "lengthMenu"=> [[20,-1], [20,Yii::t('app',"All")]],
            "info"=>false,
            "responsive"=>true,
            "dom"=> 'lfTrtip',
        ],
        'columns' => $columns
    ]); ?>
    <?php Pjax::end(); ?>
</div>
