<?php
/**
 * Created by PhpStorm.
 * User: memorymwageni
 * Date: 24/10/2018
 * Time: 14:16
 */

namespace common\helpers\report;


use yii\data\ActiveDataProvider;

class Report
{

    const DEFAULT_RANGE = 'this_week';
    public $name = 'Report';
    /** @var ActiveDataProvider $data_provider*/
    public $data_provider;
    public $date_range;
    public $start_date;
    public $end_date;
    public $other_filters=[];

    public $filter_url = '';



    public function __construct($config)
    {
        foreach ($config as $key=>$value){
            $this->$key=$value;
        }

        if (!empty($this->data_provider)){
            $this->data_provider->pagination = ['pageSize' => 250];
        }
    }


    public function filterOption($filter_option){
        $this->other_filters[]=$filter_option;
    }


    public function filterOptions($filter_options){
        $this->other_filters = array_merge($this->other_filters,$filter_options);
    }


    public function hasOtherFilters(){
        return !empty($this->other_filters);
    }

    public function hasDateFilter(){
        return !(empty($this->start_date) && empty($this->end_date) && empty($this->date_range));
    }




    public static function rangeToDate($range){
        $today=date('Y-m-d');
        switch ($range){
            case 'today':
                return array($today, $today);
            case 'this_week':
                return array(date('Y-m-d',strtotime('-1 week +1 day')),$today);
            case 'this_month':
                return array(date('Y-m-d',strtotime('-1 month +1 day')),$today);
            case '1st_quarter': {
                $year = (date('m')>6?date('Y'):date('Y')-1);
                return array($year.'-07-01',$year.'-09-31');
            }
            case '2nd_quarter': {
                $year = (date('m')>6?date('Y'):date('Y')-1);
                return array($year.'-10-01',$year.'-12-31');
            }
            case '3rd_quarter': {
                $year = (date('m')>6?date('Y')+1:date('Y'));
                return array($year.'-01-01',$year.'-03-31');
            }
            case '4th_quarter': {
                $year = (date('m')>6?date('Y')+1:date('Y'));
                return array($year.'-04-01',$year.'-06-30');
            }
            case 'this_fy': {
                return array((date('m')>6?date('Y'):date('Y')-1).'-06-30',$today);
            }
            case 'this_year':
                return array(date('Y-m-d',strtotime('-1 year +1 day')),$today);
        }

        return array($today,$today);
    }


}