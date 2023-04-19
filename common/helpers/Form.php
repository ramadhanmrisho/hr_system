<?php
/**
 * Created by PhpStorm.
 * User: memorymwageni
 * Date: 11/10/2018
 * Time: 12:47
 */

namespace common\helpers;


use dosamigos\datepicker\DatePicker;
use dosamigos\datepicker\DateRangePicker;
use kartik\widgets\Select2;
use yii\helpers\Html;

class Form
{


    public static function textInput($name, $label, $value,$orientation='vertical')
    {
        $id = 'field-' . preg_replace('#\\[|\\]#','-',$name) . '-id';
        $class = 'field-' . preg_replace('#\\[|\\]#','-',$name);

        if ($orientation=='vertical'){
            return Html::beginTag('div', ['class' => 'form-group '.$class]) . "\n"
                . Html::label($label, $id, ['class' => 'control-label']) . "\n"
                . Html::textInput($name, $value, ['id' => $id, 'class' => 'form-control']) . "\n"
                . Html::endTag('div') . "\n";
        }else{
            return Html::beginTag('div', ['class' => 'form-group '.$class]) . "\n"
                . Html::beginTag('div', ['class' => 'control-label col-sm-3 ']) . "\n"
                . Html::label($label, $id, ['class' => 'control-label']) . "\n"
                . Html::endTag('div') . "\n"
                . Html::beginTag('div', ['class' => 'col-sm-6 ']) . "\n"
                . Html::textInput($name, $value, ['id' => $id, 'class' => 'form-control']) . "\n"
                . Html::endTag('div') . "\n"
                . Html::endTag('div') . "\n";
        }
    }


    public static function dropDown($name, $label, $data,$orientation='vertical',$selection=null)
    {
        $id = 'field-' . preg_replace('#\\[|\\]#','-',$name) . '-id';
        $class = 'field-' . preg_replace('#\\[|\\]#','-',$name);


        if ($orientation=='vertical'){
            return Html::beginTag('div', ['class' => 'form-group '.$class]) . "\n"
                . Html::label($label, $id, ['class' => 'control-label']) . "\n"
                . Html::dropDownList($name, $selection,$data, ['id' => $id, 'class' => 'form-control']) . "\n"
                . Html::endTag('div') . "\n";
        }else{
            return Html::beginTag('div', ['class' => 'form-group '.$class]) . "\n"
                . Html::beginTag('div', ['class' => 'control-label col-sm-3 ']) . "\n"
                . Html::label($label, $id, ['class' => 'control-label']) . "\n"
                . Html::endTag('div') . "\n"
                . Html::beginTag('div', ['class' => 'col-sm-6 ']) . "\n"
                . Html::dropDownList($name, $selection,$data, ['id' => $id, 'class' => 'form-control']) . "\n"
                . Html::endTag('div') . "\n"
                . Html::endTag('div') . "\n";
        }
    }


    public static function multiSelect($name, $label, $data,$orientation='vertical',$selection=null)
    {
        $id = 'field-' . preg_replace('#\\[|\\]#','-',$name) . '-id';
        $class = 'field-' . preg_replace('#\\[|\\]#','-',$name);


        if ($orientation=='vertical'){
            return Html::beginTag('div', ['class' => 'form-group '.$class]) . "\n"
                . Html::label($label, $id, ['class' => 'control-label']) . "\n"
                . Html::dropDownList($name, $selection,$data, ['id' => $id, 'multiple'=>"multiple", 'class' => 'form-control multi-select']) . "\n"
                . Html::endTag('div') . "\n";
        }else{
            return Html::beginTag('div', ['class' => 'form-group '.$class]) . "\n"
                . Html::beginTag('div', ['class' => 'control-label col-sm-3 ']) . "\n"
                . Html::label($label, $id, ['class' => 'control-label']) . "\n"
                . Html::endTag('div') . "\n"
                . Html::beginTag('div', ['class' => 'col-sm-6 ']) . "\n"
                . Html::dropDownList($name, $selection,$data, ['id' => $id, 'class' => 'form-control multi-select']) . "\n"
                . Html::endTag('div') . "\n"
                . Html::endTag('div') . "\n";
        }
    }


    public static function select2($name, $label, $data,$selected='',$orientation='vertical',$multiple=false)
    {
        $id = 'field-' . preg_replace('#\\[|\\]#','-',$name) . '-id';
        $class = 'field-' . preg_replace('#\\[|\\]#','-',$name);

        if ($orientation=='vertical'){
            return Html::beginTag('div', ['class' => 'form-group '.$class]) . "\n"
                . Html::label($label, $id, ['class' => 'control-label']) . "\n"
                . Select2::widget([
                    'name'=>$name,
                    'data'=>$data,
                    'value' => $selected,
                    'options'=>['placeholder'=>'--Select--','multiple'=>$multiple,'class'=>'select2']
                ]) . "\n"
                . Html::endTag('div') . "\n";
        }else{
            return Html::beginTag('div', ['class' => 'form-group '.$class]) . "\n"
                . Html::beginTag('div', ['class' => 'control-label col-sm-3 ']) . "\n"
                . Html::label($label, $id, ['class' => 'control-label']) . "\n"
                . Html::endTag('div') . "\n"
                . Html::beginTag('div', ['class' => 'col-sm-6 ']) . "\n"
                . Select2::widget([
                    'name'=>$name,
                    'data'=>$data,
                    'value' => $selected,
                    'options'=>['placeholder'=>'--Select--','multiple'=>$multiple]
                ]) . "\n"
                . Html::endTag('div') . "\n"
                . Html::endTag('div') . "\n"
                . '<br>';
        }
    }


    public static function dosAmigoDate($config,$label,$orientation='vertical')
    {
        if (!isset($config['name'])) throw new \Exception('`name` should be one of the keys supplied in config');
        $name = $config['name'];
        $id = 'field-' . preg_replace('#\\[|\\]#','-',$name) . '-id';
        $class = 'field-' . preg_replace('#\\[|\\]#','-',$name);


        if ($orientation=='vertical'){
            return Html::beginTag('div', ['class' => 'form-group '.$class]) . "\n"
                . Html::label($label, $id, ['class' => 'control-label']) . "\n"
                . DatePicker::widget($config). "\n"
                . Html::endTag('div') . "\n";
        }else{
            return Html::beginTag('div', ['class' => 'form-group '.$class]) . "\n"
                . Html::beginTag('div', ['class' => 'control-label col-sm-3 ']) . "\n"
                . Html::label($label, $id, ['class' => 'control-label']) . "\n"
                . Html::endTag('div') . "\n"
                . Html::beginTag('div', ['class' => 'col-sm-6 ']) . "\n"
                . DatePicker::widget($config) . "\n"
                . Html::endTag('div') . "\n"
                . Html::endTag('div') . "\n";
        }
    }

    public static function dateRangePicker($config,$label,$orientation='vertical')
    {
        if (!isset($config['name'])) throw new \Exception('`name` should be one of the keys supplied in config');
        $name = $config['name'];
        $id = 'field-' . preg_replace('#\\[|\\]#','-',$name) . '-id';
        $class = 'field-' . preg_replace('#\\[|\\]#','-',$name);

        $addon = <<< HTML
<div class="input-group-addon">
    <i class="glyphicon glyphicon-calendar"></i>
</div>
HTML;

        if ($orientation=='vertical'){
            return Html::beginTag('div', ['class' => 'form-group '.$class]) . "\n"
                . Html::label($label, $id, ['class' => 'control-label']) . "\n"
                . Html::beginTag('div',['class'=>'input-group drp-container'])
                . \kartik\daterange\DateRangePicker::widget($config).$addon. "\n"
                . Html::endTag('div') . "\n"
                . Html::endTag('div') . "\n";
        }else{
            return Html::beginTag('div', ['class' => 'form-group '.$class]) . "\n"
                . Html::beginTag('div', ['class' => 'control-label col-sm-3 ']) . "\n"
                . Html::label($label, $id, ['class' => 'control-label']) . "\n"
                . Html::endTag('div') . "\n"
                . Html::beginTag('div', ['class' => 'col-sm-6 ']) . "\n"
                . \kartik\daterange\DateRangePicker::widget($config).$addon . "\n"
                . Html::endTag('div') . "\n"
                . Html::endTag('div') . "\n";
        }
    }

    public static function textArea($name, $label, $value,$options=[],$orientation='vertical')
    {
        $id = 'field-' . preg_replace('#\\[|\\]#','-',$name) . '-id';
        $class = 'field-' . preg_replace('#\\[|\\]#','-',$name);

        if ($orientation=='vertical'){
            return Html::beginTag('div', ['class' => 'form-group '.$class]) . "\n"
                . Html::label($label, $id, ['class' => 'control-label']) . "\n"
                . Html::textarea($name, $value, array_merge(['id' => $id, 'class' => 'form-control'],$options)) . "\n"
                . Html::endTag('div') . "\n";
        }else{
            return Html::beginTag('div', ['class' => 'form-group '.$class]) . "\n"
                . Html::beginTag('div', ['class' => 'control-label col-sm-3 ']) . "\n"
                . Html::label($label, $id, ['class' => 'control-label']) . "\n"
                . Html::endTag('div') . "\n"
                . Html::beginTag('div', ['class' => 'col-sm-6 ']) . "\n"
                . Html::textarea($name, $value, array_merge(['id' => $id, 'class' => 'form-control'],$options)) . "\n"
                . Html::endTag('div') . "\n"
                . Html::endTag('div') . "\n";
        }
    }

}