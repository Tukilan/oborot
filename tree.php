<?php
require_once(__DIR__.'/apple.php');
require_once(__DIR__.'/pear.php');
class Tree{
    public $objects;
    public $type;
    function __construct($typeObj){
        
        if ($typeObj == 'apple'){
            $initializeCount = rand(40,50);
            for ($i=0; $i < $initializeCount; $i++) { 
                $this->objects[] = new Apple();
            }
            $this->type = $typeObj;
        }
        if ($typeObj == 'pear'){
            $initializeCount = rand(0,20);  
            for ($i=0; $i < $initializeCount; $i++) { 
                $this->objects[] = new Pear();
            }
            $this->type = $typeObj;
        }
        if (empty($this->type)){
            //error
        }
    }

    public function collect(){
        $objects = $this->objects;
        $this->objects = [];
        return $objects;
    }
}