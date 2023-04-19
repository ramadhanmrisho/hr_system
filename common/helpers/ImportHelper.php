<?php
/**
 * Created by PhpStorm.
 * User: memorymwageni
 * Date: 16/02/2019
 * Time: 16:15
 */

namespace common\helpers;


use common\models\Staff;
use Throwable;


class ImportHelper
{

    /**
     * @param $modal
     * @param $column
     * @param $value
     * @return mixed
     * @throws ImportException
     */
    public static function value2Id($modal, $column, $value){
        try{
            return $modal::findOne([$column=>$value])->id;
        }catch(\Exception $e){
            throw new ImportException("Unknown value {$value} related to ".preg_replace('/common\\\models\\\/','',$modal).' : '.$e->getMessage());
        }
    }

    /**
     * @param $modal
     * @param $column
     * @param $value
     * @param $pcolumn
     * @param $pvalue
     * @return mixed
     * @throws \Exception
     */
    public static function value2Id2($modal, $column, $value, $pcolumn, $pvalue){
        try{
            $datas = $modal::find()->where([$column=>$value]);
               if($pcolumn !=null && $pvalue!=null){
                   $datas->andwhere([$pcolumn=>$pvalue]);
               }
                return $datas->one()->id;
        }catch(\Exception $e){
            throw new \Exception("Failed to get an id for {$modal} (column: $column, value: $value)");
        }
    }


    public static function staffId2Id($staff_id){
        return Staff::findOne(['staff_id'=>$staff_id])->id;
    }

    public static function value($row,$header,$column){
        $index = array_search($column, $header);
        return $index===false?null:$row[$index];
    }

    public static function hasValue($row, $header, $column)
    {
        $index = array_search($column, $header);
        if ($index === false) {
            return false;
        } else {
            return !empty($row[$index]);
        }
    }
}

class ImportException extends \Exception{

    public $msg;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->msg = $message;
    }
}