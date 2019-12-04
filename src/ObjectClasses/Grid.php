<?php declare(strict_types = 1);
/**
 * Created by Joey Overby
 * Email: Joey.Overby@MadWireMedia.com
 * Date: 12/3/19
 */

namespace JoeyOverby\PHPHelpers\ObjectClasses;


use JoeyOverby\PHPHelpers\Exceptions\InvalidParameterException;
use JoeyOverby\PHPHelpers\Exceptions\PHPHelpersException;

/**
 * Class Grid
 */
class Grid {
    
    /** @var int|null $width */
    protected ?int $width = null;
    
    /** @var int|null $height */
    protected ?int $height = null;
    
    /** @var array $markedLocations */
    protected array $markedLocations = [];
    
    /** @var int $locationMarker */
    protected int $locationMarker = 1;
    
    
    /**
     * Grid constructor.
     *
     * @param int $width  - The width of the grid  (must be greater than 0)
     * @param int $height - The height of the grid (must be greater than 0)
     *
     * @throws PHPHelpersException
     */
    public function __construct(int $width = null, int $height = null) {
        if($height !== null && $width !== null){
            $this->setWidth($width);
            $this->setHeight($height);
        }
    }
    
    /**
     * @return int|null
     */
    public function getWidth() : ?int {
        return $this->width;
    }
    
    /**
     * @param int $width
     *
     * @throws PHPHelpersException
     */
    public function setWidth(int $width) : void {
        if($width > 0) {
            $this->width = $width;
        } else {
            throw new InvalidParameterException("Width must be greater than 0");
        }
    }
    
    /**
     * @return int|null
     */
    public function getHeight() : ?int {
        return $this->height;
    }
    
    /**
     * @param int $height
     *
     * @throws PHPHelpersException
     */
    public function setHeight(int $height) : void {
        if($height > 0) {
            $this->height = $height;
        } else {
            throw new InvalidParameterException("Height must be greater than 0");
        }
    }
    
    /**
     * @param int  $xVal                 - X coordinate to mark off
     * @param int  $yVal                 - Y coordinate to mark off
     * @param bool $throwIfAlreadyMarked - If true, throws an exception if this location as already marked off
     *
     * @throws InvalidParameterException
     */
    public function markLocation(int $xVal, int $yVal, bool $throwIfAlreadyMarked = false) : void {
        if($throwIfAlreadyMarked === true) {
            //See if this location is already marked
            if($this->isLocationMarked($xVal, $yVal) === true) {
                throw new InvalidParameterException("Location Already Marked: (" . $xVal . ", " . $yVal . ")");
            }
        }
        
        
        if($this->getWidth() !== null){
            if($xVal < 0 || $xVal >= $this->getWidth()){
                throw new InvalidParameterException("xVal must be between 0-" . ($this->getWidth()-1) . ", Given: " .
                                                    $xVal);
            }
        }
    
        if($this->getHeight() !== null){
            if($yVal < 0 || $yVal >= $this->getHeight()){
                throw new InvalidParameterException("yVal must be between 0-" . ($this->getHeight()-1) . ", Given: " .
                                                    $xVal);
            }
        }
        
        
        $this->markedLocations[$xVal][$yVal] = $this->locationMarker;
    }
    
    /**
     * @param GridPoint $gridPoint
     *
     * @throws InvalidParameterException
     */
    public function markGridPoint(GridPoint $gridPoint) : void{
        $this->markLocation($gridPoint->getXVal(), $gridPoint->getYVal());
    }
    
    
    
    
    /**
     * Returns true if this location is already marked off.
     *
     * NOTE: This DOES NOT verify if a location is valid, simply if it is marked!
     *
     * @param int $xVal
     * @param int $yVal
     *
     * @return bool
     */
    public function isLocationMarked(int $xVal, int $yVal) : bool {
        if(isset($this->markedLocations[$xVal][$yVal]) &&
           $this->markedLocations[$xVal][$yVal] === $this->locationMarker) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Returns true if this grid point is marked
     *
     * @param GridPoint $gridPoint
     *
     * @return bool
     */
    public function isGridPointMarked(GridPoint $gridPoint): bool {
        return $this->isLocationMarked($gridPoint->getXVal(), $gridPoint->getYVal());
    }
    
    
    /**
     *
     * Returns an array of overlapping locations
     *
     * @param Grid $otherGrid
     *
     * @return GridPoint[]
     */
    public function getOverlapLocations(Grid $otherGrid): array{
        $overlappedLocations = [];
        
        $myMarkedLocations = $this->getMarkedLocations();
        
        /**
         * @var  int $xVal
         * @var  int[] $yValues
         */
        foreach($myMarkedLocations as $gridPoint) {
            if($otherGrid->isGridPointMarked($gridPoint)){
                $overlappedLocations[] = $gridPoint;
            }
        }
        
        return $overlappedLocations;
    }
    
    
    
    /**
     * @return GridPoint[]
     */
    public function getMarkedLocations() : array {
        $toReturn = [];
        
        foreach($this->markedLocations as $xVal => $yVals) {
            foreach(array_keys($yVals) as $yVal) {
                $toReturn[] = new GridPoint($xVal, $yVal);
            }
        }
        return $toReturn;
    }
    
    /**
     * @param array $markedLocations
     */
    protected function setMarkedLocations(array $markedLocations) : void {
        $this->markedLocations = $markedLocations;
    }
    
    
}