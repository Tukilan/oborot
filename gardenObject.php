<?php
require_once(dirname(__FILE__) ."/tree.php");
abstract class objectProperty{
    public $uniq;
    public $classObject;
    public $entity;

    function __construct($classObject,$typeObj){
        $this->uniq = uniqid();

        if ($classObject == 'tree'){
            $this->entity = new Tree($typeObj);
            $this->classObject = $classObject;
        }
    }
}

class GardenObject extends objectProperty{

    public function collect(){
        if (method_exists($this->entity,'collect')){
            $data = $this->entity->collect();
            if (!empty($data)){
                foreach ($data as $k => &$v) {
                    $v->objectId = $this->uniq;
                }
            }
            return ['classObject'=>$this->classObject,'type'=>$this->entity->type,'objects'=>$data];
        }
        return [];
    }
}   