<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use dosamigos\chartjs\ChartJs;
use yii\db\Query;
?>

<center><h4><?= $chart_title; ?></h4></center>

<?=Html::beginForm(['/dce-drc-task-register/charts'],'GET')?>
        
<div class="col-sm-12 text-right" style="margin-top:10px;">
    <center><u style="color:#01579B;"><b>Year : <?= $year; ?></b></u></center><br><br>
</div>

<div class="col-sm-12" style="padding-left:0;">
    <div class="col-sm-2">
        <?= \common\helpers\Form::select2($filter_year['name'],$filter_year['label'],$filter_year['data'],isset($filter_year['selected'])?$filter_year['selected']:null)?>
    </div>
    <?php if(isset($filter_region) && !empty($filter_region)) :?>
        <div class="col-sm-2">
            <?= \common\helpers\Form::select2($filter_region['name'],$filter_region['label'],$filter_region['data'],isset($filter_region['selected'])?$filter_region['selected']:null)?>
        </div>
    <?php endif; ?>
    <?php if(isset($filter_district) && !empty($filter_district)) :?>
    <div class="col-sm-2">
        <?= \common\helpers\Form::select2($filter_district['name'],$filter_district['label'],$filter_district['data'],isset($filter_district['selected'])?$filter_district['selected']:null)?>
    </div>
    <?php endif; ?>
    <div class="col-sm-1">
        <label style="visibility: hidden;">fake</label>
        <?=Html::submitButton('Filter',['class'=>'btn btn-primary'])?>
    </div>
</div>

<!--<span style="position:absolute; top:50%; bottom:50% left:7%; right:93%;">Frequency count</span>-->


<?= ChartJs::widget([
    'type' => 'line',
    'options' => [
        'height' => 150,
        'width' => 400
    ],
    'data' => [
        'labels' => ['January','February','March','April','May','June','July','August','September','October','November','December'],
        'datasets' => [
            [
                'label' => "Semina",
                'backgroundColor' => "rgba(26,140,255,0.3)",
                'borderColor' => "rgba(26,140,255,0.3)",
                'pointBackgroundColor' => "rgba(26,140,255,0.3)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(26,140,255,0.3)",
                'data' => $semina
            ],
            [
                'label' => "Kufungua Klabu",
                'backgroundColor' => "rgba(87,185,0,0.3)",
                'borderColor' => "rgba(87,185,0,0.2)",
                'pointBackgroundColor' => "rgba(87,185,0,0.3)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "rgba(87,185,0,0.3)",
                'pointHoverBorderColor' => "rgba(87,185,0,0.3)",
                'data' => $Kufungua_Klabu
            ],
            [
                'label' => "Kuimarisha Klabu",
                'backgroundColor' => "rgba(175,175,175,0.2)",
                'borderColor' => "rgba(175,175,175,1)",
                'pointBackgroundColor' => "rgba(175,175,175,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(175,175,175,1)",
                'data' => $Kuimarisha_Klabu
            ],
            [
                'label' => "Maonesho",
                'backgroundColor' => "rgba(140,39,12,0.2)",
                'borderColor' => "rgba(140,39,12,0.2)",
                'pointBackgroundColor' => "rgba(140,39,12,0.2)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(140,39,12,0.2)",
                'data' => $Maonesho
            ],
            [
                'label' => "Vipindi vya redio na TV",
                'backgroundColor' => "rgba(99,255,222,0.2)",
                'borderColor' => "rgba(99,255,222,1)",
                'pointBackgroundColor' => "rgba(99,255,222,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(99,255,222,1)",
                'data' => $Vipindi_vya_redio_na_TV
            ],
            [
                'label' => "Mkutano wa hadhara",
                'backgroundColor' => "rgba(40,119,222,0.2)",
                'borderColor' => "rgba(40,119,222,1)",
                'pointBackgroundColor' => "rgba(40,119,222,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(40,119,222,1)",
                'data' => $Mkutano_wa_hadhara
            ],
            [
                'label' => "Utoaji wa habari",
                'backgroundColor' => "rgba(255, 0, 0, 0.2)",
                'borderColor' => "rgba(255, 0, 0, 0.2)",
                'pointBackgroundColor' => "rgba(255, 0, 0, 0.2)",
                'pointBorderColor' => "#eef",
                'pointHoverBackgroundColor' => "#eef",
                'pointHoverBorderColor' => "rgba(255, 0, 0, 0.2)",
                'data' => $Utoaji_wa_habari
            ],
        ]
    ]
]);
?>

<?php if(isset($year)):?>

    <center><br><h6 style="color:#607D8B;"> Frequency count Against Month </h6></center>

<?php endif; ?>

<?=Html::endForm()?>