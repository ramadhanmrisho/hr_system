<?php
/**
 * Created by PhpStorm.
 * User: memorymwageni
 * Date: 24/10/2018
 * Time: 09:27
 */

namespace common\helpers\report;

use Yii;

class Query
{
    private $where=[];
    private $group_by=[];
    private $columns=[];
    private $table='';
    private $joins=[];
    private $order_by=[];


    public static function from($table){
        $query = new static();
        $query->table = $table;
        return $query;
    }

    public function where($condition){
        $this->where[] = $condition;
        return $this;
    }


    public function andWhere($condition){
        return $this->where($condition);
    }

    public function groupBy($group_by){
        $this->group_by[]=$group_by;
        return $this;
    }

    public function select($select){
        if (is_array($select)){
            $this->columns=array_merge($this->columns,$select);
        }else{
            $this->columns[]=$select;
        }
        return $this;
    }

    public function innerJoin($table,$condition){
        return $this->join($table,$condition,'INNER');
    }

    public function leftJoin($table,$condition){
        return $this->join($table,$condition,'LEFT');
    }

    public function rightJoin($table,$condition){
        return $this->join($table,$condition,'RIGHT');
    }

    public function join($table,$condition,$type='INNER'){
        $this->joins[]=['table'=>$table,'condition'=>$condition, 'type'=>$type];
        return $this;
    }

    private function build(){
        $sql='SELECT ';

        if (empty($this->columns)) $this->columns = ['*'];
        foreach ($this->columns as $column){
            $sql.=''.$column.', ';
        }

        $sql = preg_replace('/, $/','',$sql);

        $sql.=' FROM '.(is_callable($this->table)?call_user_func($this->table,$this):$this->table);

        //joins
        foreach ($this->joins as $join){
            $sql.=' '.$join['type'].' JOIN '.$join['table'].' ON ';
            if (is_array($join['condition'])){
                foreach ($join['condition'] as $key=>$value){
                    $sql.=$key.'='.$value.' AND ';
                }
            }else{
                $sql.=$join['condition'].'';
            }
            $sql = preg_replace('/ AND$/','',trim($sql));
        }

        $sql = preg_replace('/ AND$/','',trim($sql));

        //Where conditions
        if (is_array($this->where) && count($this->where)>0) $sql.=' WHERE ';
        foreach ($this->where as $condition){
            if (is_array($condition)){
                foreach ($condition as $key=>$value){
                    $sql.=$key.'=\''.$value.'\' AND ';
                }
            }else{
                $sql.=''.$condition.' AND ';
            }
        }

        $sql = preg_replace('/AND$/','',trim($sql));
        if (!empty($this->group_by))
            $sql.=' GROUP BY '.join(',',$this->group_by);

        if (!empty($this->order_by))
            $sql.=' ORDER BY '.join(',',$this->order_by);

        return $sql;
    }


    public function sql(){
        return $this->build();
    }


    public function queryAll(){
        return Yii::$app->db->createCommand($this->sql())->queryAll();
    }

    public static function executeSQL($sql){
        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    public function queryOne(){
        return Yii::$app->db->createCommand($this->sql())->queryOne();
    }

    public function orderBy($order_by)
    {
        if (!is_array($order_by))
            $this->order_by[] = $order_by;
        else
            $this->order_by = $order_by;

        return $this;
    }
}