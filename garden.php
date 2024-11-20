<?php
require_once(__DIR__.'/gardenObject.php');
class Garden {
    public $objects;

    public $collectedData = []; 
    public $limits = [
        'tree'=>[
            'apple'=>15,
            'pear'=>10,
        ],
    ];

    function __construct(){
        $this->fillGarden();
    }   

    public function collect(){
        if (!empty($this->objects)){
            foreach ($this->objects as $k => $v) {
                if (method_exists($v,'collect')){
                    $data = $v->collect();
                    if (isset($data['classObject']) && isset($data['type'])){
                        if (!empty($data['objects'])){
                            if (isset($this->collectedData[$data['classObject']][$data['type']])){
                                
                                $this->collectedData[$data['classObject']][$data['type']] = array_merge($data['objects'],$this->collectedData[$data['classObject']][$data['type']]);
                            } else {
                                $this->collectedData[$data['classObject']][$data['type']] = $data['objects'];
                            }
                        }
                    }
                    
                }
            }
        }
        return $this->collectedData;
    }

    public function countCollectedObjects(){
        foreach ($this->collectedData as $classObject => $dataObject) {
            foreach ($dataObject as $type => $entities) {
                echo $type.' - '.count($entities).PHP_EOL;    
            }
            
        }
    }

    public function getWeight(){
        $weight = [];
        foreach ($this->collectedData as $classObject => $dataObject) {
            foreach ($dataObject as $type => $entities) {
                if (!isset($weight[$type])) $weight[$type] = 0;
                foreach ($entities as $key => $entity) {
                    $weight[$type]+= $entity->weight;
                }
            }
        }
        return $weight;
    }
    public function getMaxWeight($classObject,$type){
        $apples = [];
        $max = 0;
        $uid = '';
        if (isset($this->collectedData[$classObject][$type])) {
            foreach ($this->collectedData[$classObject][$type] as $key => $entity) {
                if ($entity->weight >= $max){
                    $max = $entity->weight;
                    $uid = $entity->objectId;
                }
            }
        }
        return ['id'=>$uid,'max'=> $max];
    }
    public function fillGarden(){
        if (isset($this->limits) && !empty($this->limits)){
            foreach ($this->limits as $classObject => $arrObjects) {
                if (is_array($arrObjects)){
                    foreach ($arrObjects as $typeObj => $count) {
                        for ($i=0; $i < $count; $i++) { 
                            $this->objects[] = new GardenObject($classObject,$typeObj);
                        }
                    }
                }
            }
        }
    }

}
