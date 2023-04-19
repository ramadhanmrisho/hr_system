<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\DistrictSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Districts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="district-index">


    <?php Pjax::begin(); ?>


    <p>
        <?= Html::a('<span class="fa fa-plus">Add New District</span>', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= \fedemotta\datatables\DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            ['attribute'=>'name','value'=>'name','label'=>'District Name'],
            ['attribute'=>'region_id','value'=>function($model){
               
               if(!empty($model->region)){
                   return $model->region->name;
               }
               else{return 'N/A'; }
            
            }],
           
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
