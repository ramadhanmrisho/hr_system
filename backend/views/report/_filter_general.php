<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $report common\helpers\report\Report*/
?>

<div class="pro-theme-form">

    <div class="row">
        <div class="col-sm-1 hidden">
            <h5>Filter  </h5>
        </div>

        <div class="col-sm-12">

            <?=Html::beginForm([$report->filter_url],'GET')?>
            <div class="row">

                <?php
                if ($report->hasOtherFilters()){
                    foreach ($report->other_filters as $filter){
                    ?>
                    <div class="col-sm-2" style="max-height: 68px;">
                        <?php if (!empty($filter['type']) && $filter['type']=='date'){
                            echo \common\helpers\Form::dosAmigoDate([
                                'name'=>$filter['name'],
                                'value'=>$filter['selected'],
                                'options' => ['autocomplete' => "off",'placeholder'=>'All'],
                                'clientOptions'=>[
                                    'format'=>'yyyy-mm-dd',
                                    'autoclose' => true,
                                    'clearBtn' => true
                                ]
                            ],$filter['label']);
                        }else{
                            echo \common\helpers\Form::select2($filter['name'],$filter['label'],$filter['data'],isset($filter['selected'])?$filter['selected']:null);
                        }?>
                    </div>
                <?php
                    }
                }
                ?>

                <?php
                if ($report->hasDateFilter()){ ?>
                <div class="col-sm-2">
                    <?= \common\helpers\Form::dropDown('range','Choose range',[
                        'today'=>'Today',
                        'this_week'=>'This week',
                        'this_month'=>'This Month',
                        '1st_quarter'=>'1st Quarter',
                        '2nd_quarter'=>'2nd Quarter',
                        '3rd_quarter'=>'3rd Quarter',
                        '4th_quarter'=>'4th Quarter',
                        'this_fy'=>'This Financial Year',
                        'this_year'=>'This Year',
                        'custom'=>'Custom'
                    ],'vertical',$report->date_range)?>
                </div>

                    <div class="col-sm-2">
                        <?= \common\helpers\Form::dosAmigoDate([
                            'name'=>'start_date',
                            'value'=>$report->start_date,
                            'clientOptions'=>['format'=>'yyyy-mm-dd']
                        ],'Start Date')?>
                    </div>

                    <div class="col-sm-2">
                        <?= \common\helpers\Form::dosAmigoDate([
                            'name'=>'end_date',
                            'value'=>$report->end_date,
                            'clientOptions'=>['format'=>'yyyy-mm-dd']
                        ],'End Date')?>
                    </div>

                <?php }?>

                <div class="col-sm-1">
                    <label style="visibility: hidden;">####</label>
                    <?=Html::submitButton('Filter',['class'=>'btn btn-primary'])?>
                </div>

            </div>

            <?=Html::endForm()?>

        </div>
    </div>

</div>
