<?php declare(strict_types = 1);
/**
 * Created by Joey Overby
 * Date: 2019-03-21
 * Time: 13:14
 */

namespace JoeyOverby\PHPHelpers\ObjectClasses;

/**
 * Class Queue
 * Quick implementation of FIFO Queue
 */
class Queue {
    
    /** @var array $values */
    protected $values = [];
    
    
    /**
     * Queue constructor.
     *
     * @param array $array - If not empty, will take this array and convert it into the Queue object
     */
    public function __construct(array $array = []) {
        foreach($array as $val){
            $this->push($val);
        }
    }
    
    
    /**
     * Returns the next element
     *
     * @return mixed
     */
    public function pop() {
        $toReturn = $this->values[0];
        
        for($i = 1; $i < $this->size(); $i++) {
            
            $this->values[$i - 1] = $this->values[$i];
        }
        
        unset($this->values[$this->size() - 1]);
        
        return $toReturn;
    }
    
    /**
     * Add a value to the Queue
     *
     * @param $value
     */
    public function push($value) {
        $this->values[$this->size()] = $value;
    }
    
    /**
     * Returns the current size of the queue
     * @return int
     */
    public function size() : int {
        return count($this->values);
    }
    
    
}