<?php declare(strict_types = 1);
/**
 * Created by Joey Overby
 * Repositories: https://github.com/JoeyOverby
 * Date: 12/3/19
 */


namespace JoeyOverby\PHPHelpers\ObjectClasses;

/**
 * Class GridPoint
 *
 * Just a wrapper for Grid Points (to make sure that we are returning the same type of information)
 *
 * @package JoeyOverby\PHPHelpers\ObjectClasses
 */
class GridPoint {
    
    /** @var int|null $xVal */
    protected ?int $xVal = null;
    
    /** @var int|null $yVal */
    protected ?int $yVal = null;
    
    /**
     * GridPoint constructor.
     *
     * @param int|null $xVal - x coordinate
     * @param int|null $yVal - y coordinate
     */
    public function __construct(?int $xVal, ?int $yVal) {
        $this->setXVal($xVal);
        $this->setYVal($yVal);
    }
    
    
    /**
     * @return int|null
     */
    public function getXVal() : ?int {
        return $this->xVal;
    }
    
    /**
     * @param int|null $xVal
     */
    public function setXVal(?int $xVal) : void {
        $this->xVal = $xVal;
    }
    
    /**
     * @return int|null
     */
    public function getYVal() : ?int {
        return $this->yVal;
    }
    
    /**
     * @param int|null $yVal
     */
    public function setYVal(?int $yVal) : void {
        $this->yVal = $yVal;
    }
    
    
    
    
    
    
}