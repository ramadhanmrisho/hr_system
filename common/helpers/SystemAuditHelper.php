<?php
/**
 * Created by PhpStorm.
 * User: memorymwageni
 * Date: 05/02/2019
 * Time: 12:56
 */

namespace common\helpers;


use common\models\SystemAudit;

class SystemAuditHelper
{

    private $class;
    private $id;
    private $action;
    private $description;
    private $old_attributes;
    private $new_attributes;

    public static function log($class, $id, $action, $description, $old_attributes = null,$new_attributes=null){
        $obj = new SystemAuditHelper();
        $obj->class = $class;
        $obj->id = $id;
        $obj->action = $action;
        $obj->description = $description;
        $obj->old_attributes = $old_attributes;
        $obj->new_attributes = $new_attributes;
        return $obj;
    }

    public function save(){
        SystemAudit::log2($this->class,$this->id,$this->action,$this->description,$this->old_attributes,$this->new_attributes);
    }

    /**
     * @param mixed $old_attributes
     */
    public function setOldAttributes($old_attributes)
    {
        $this->old_attributes = $old_attributes;
    }

    /**
     * @param mixed $new_attributes
     */
    public function setNewAttributes($new_attributes)
    {
        $this->new_attributes = $new_attributes;
    }
}