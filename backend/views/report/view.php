<?php

use fedemotta\datatables\DataTables;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $report \common\helpers\report\Report*/

$this->title = $report->name;
$this->params['breadcrumbs'][] = ['label' => 'Report'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pro-theme-view">

    <br>
    <h2><?= $report->name?></h2>

    <br>
    <p>
        <?= ($report->hasDateFilter() || $report->hasOtherFilters())?$this->render('_filter_general',['report'=>$report]):'' ?>
    </p>
    <hr>


    <img src="https://via.placeholder.com/150" class="visible-print" width="50px">



    <?php

    echo \kartik\grid\GridView::widget([
        'dataProvider'=>$report->data_provider,
        //'filterModel' => $searchModel,
        'autoXlFormat'=>true,
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'export'=>[
            'showConfirmAlert'=>true,
            'target'=>\kartik\grid\GridView::TARGET_BLANK,

        ],

        'columns'=>[
        ],
        'pjax'=>true,
       'caption'=>$report->name.'( From '.date("F j, Y",strtotime($report->start_date)).' To '.date("F j, Y",strtotime($report->end_date)).')',
        'floatHeader' => false,
        'showPageSummary'=>false,
        'panel'=>[
            'type'=>'primary',
            //'heading'=>$report->name,
        ]
    ]);

    ?>


</div>
