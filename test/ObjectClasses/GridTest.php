<?php declare(strict_types = 1);
/**
 * Created by Joey Overby
 * Repositories: https://github.com/JoeyOverby
 * Date: 12/3/19
 */


namespace JoeyOverby\PHPHelpers\Test\ObjectClasses;

use JoeyOverby\PHPHelpers\Exceptions\InvalidParameterException;
use JoeyOverby\PHPHelpers\Exceptions\PHPHelpersException;
use JoeyOverby\PHPHelpers\ObjectClasses\Grid;
use JoeyOverby\PHPHelpers\ObjectClasses\GridPoint;
use JoeyOverby\PHPHelpers\Test\PHPHelpersTestCase;
use JoeyOverby\PHPHelpers\Test\TestHelpers;

/**
 * Class GridTest
 *  Simple tests for the Grid Object
 *
 * @package JoeyOverby\PHPHelpers\Test\ObjectClasses
 */
class GridTest extends PHPHelpersTestCase {
    
    
    protected const MIN_DIMENSION = 1;
    
    /** @var int MAX_DIMENSION */
    protected const MAX_DIMENSION = 100;
    
    /**
     * Setup functions for these tests
     */
    public static function setUpBeforeClass() : void {
        parent::setUpBeforeClass();
    }
    
    
    /**
     * Verifies that the setting/getting of height works as expected
     *
     * @test
     * @throws PHPHelpersException
     */
    public function testGetSetHeight() {
        $sut = $this->createSUT();
        
        $height = $sut->getHeight();
        self::assertNotNull($height, "Created object can't have a null height");
        
        $newHeight = $height + 1;
        $sut->setHeight($newHeight);
        
        self::assertEquals($newHeight, $sut->getHeight(), "Failed to set new height");
    }
    
    /**
     * Verifies that a height less than 1 throws an exception
     *
     * @throws PHPHelpersException
     */
    public function testInvalidHeightThrowsException() : void {
        self::expectException(InvalidParameterException::class);
        new Grid(50, 0);
    }
    
    /**
     * Verifies that a height less than 0 throws an exception
     *
     * @throws PHPHelpersException
     */
    public function testNegativeHeightThrowsException() : void {
        self::expectException(InvalidParameterException::class);
        new Grid(50, -50);
    }
    
    
    /**
     * Verifies that the setting/getting of height works as expected
     *
     * @throws PHPHelpersException
     */
    public function testGetSetWidth() {
        $sut = $this->createSUT();
        
        $width = $sut->getWidth();
        self::assertNotNull($width, "Created object can't have a null width");
        
        $newWidth = $width + 1;
        $sut->setWidth($newWidth);
        
        self::assertEquals($newWidth, $sut->getWidth(), "Failed to set new width");
        
    }
    
    /**
     * Verifies that a width of 0 throws an exception
     *
     * @throws PHPHelpersException
     */
    public function testInvalidWidthThrowsException() : void {
        self::expectException(InvalidParameterException::class);
        new Grid(0, 5);
    }
    
    /**
     * Verifies that a negative width throws an exception
     *
     * @throws PHPHelpersException
     */
    public function testNegativeWidthThrowsException() : void {
        self::expectException(InvalidParameterException::class);
        new Grid(-20, 5);
    }
    
    
    /**
     * Verifies constructor can be called.
     *
     * @throws PHPHelpersException
     */
    public function test__construct() {
        $sut = $this->createSUT();
        self::assertNotNull($sut, "Failed to create a new Grid object");
    }
    
    /**
     * Verifies you can mark a path
     *
     * @throws PHPHelpersException
     */
    public function testMarkPath() : void {
        $locationsToMark = [];
        
        $sut        = $this->createSUT();
        $gridHeight = $sut->getHeight();
        $gridWidth  = $sut->getWidth();
        
        
        $markedLocations = [];
        
        //We are going to randomly mark about a third of the locations in this grid and verify that it in fact did
        // mark them off.
        
        for($heightCount = 0; $heightCount < intval(floor($gridHeight / 3)); $heightCount++) {
            for($widthCount = 0; $widthCount < intval(floor($gridHeight / 3)); $widthCount++) {
                //Generate random x,y coordinate inside of the grid.
                $randomX = TestHelpers::getRandomInt(0, $gridWidth-1);
                $randomY = TestHelpers::getRandomInt(0, $gridHeight-1);
                
                echo "Adding Location: (" . $randomX . ", " . $randomY . ") as Marked" . PHP_EOL;
                $sut->markLocation($randomX, $randomY, false);
                $markedLocations[$randomX][] = $randomY; //Mark this location as visited
            }
        }
        
        //Now validate that all of these locations were marked, and that every non marked is still not marked
        $totalVerified = 0;
        for($xVal = 0; $xVal < $gridWidth; $xVal++) {
            for($yVal = 0; $yVal < $gridHeight; $yVal++) {
                if(isset($markedLocations[$xVal]) && in_array($yVal, $markedLocations[$xVal])) {
                    $shouldBeFound = true;
                    $totalVerified++;
                } else {
                    $shouldBeFound = false;
                    $totalVerified++;
                }
                
                self::assertEquals($shouldBeFound, $sut->isLocationMarked($xVal, $yVal));
                
            }
        }
        
        self::assertEquals($totalVerified, $gridWidth * $gridHeight, "Didn't Validate all locations");
        echo "Validated " . $totalVerified . " Grid Locations" . PHP_EOL;
        
    }
    
    /**
     * Verifies you can mark a path
     *
     * @throws PHPHelpersException
     */
    public function testGetOverlapLocations() : void {
        $locationsToMark = [];
        
        $sut        = $this->createSUT();
        
        $gridHeight = $sut->getHeight();
        $gridWidth  = $sut->getWidth();
        
        
        $markedLocations = [];
        
        //We are going to randomly mark about a third of the locations in this grid and verify that it in fact did
        // mark them off.
        
        for($heightCount = 0; $heightCount < intval(floor($gridHeight / 3)); $heightCount++) {
            for($widthCount = 0; $widthCount < intval(floor($gridHeight / 3)); $widthCount++) {
                //Generate random x,y coordinate inside of the grid.
                $randomX = TestHelpers::getRandomInt(0, $gridWidth-1);
                $randomY = TestHelpers::getRandomInt(0, $gridHeight-1);
                
                echo "Adding Location: (" . $randomX . ", " . $randomY . ") as Marked" . PHP_EOL;
                $sut->markLocation($randomX, $randomY, false);
                $markedLocations[$randomX][] = $randomY; //Mark this location as visited
            }
        }
        
        //Now duplicate this and check all overlaps match all marked locations
        $otherSUT = clone $sut;
        
        $markedLocations = $sut->getMarkedLocations();
        
        $overlappedLocs = $sut->getOverlapLocations($otherSUT);
        
        
        self::assertEquals($markedLocations, $overlappedLocs, "Failed to return same overlaps");
        
    }
    
    
    /**
     * Simple hard coded overlap test
     *
     * @test
     * @throws PHPHelpersException
     */
    public function testSimpleOverlapTest() : void{
        
        $grid = new Grid(10, 10);
        $otherGrid = new Grid(10,10);
        
        $locationsToMark = [
            new GridPoint(1, 1),
            new GridPoint(1, 2),
            new GridPoint(4, 4),
            new GridPoint(8, 9)
        ];
        
        
        foreach($locationsToMark as $gridPoint){
            $grid->markGridPoint($gridPoint);
            $otherGrid->markGridPoint($gridPoint);
        }
        
        //Mark a few more random ones
        $grid->markLocation(2, 2);
        $grid->markLocation(2, 9);
        $grid->markLocation(3, 5);
        
        $otherGrid->markLocation(5, 2);
        $otherGrid->markLocation(5, 4);
        $otherGrid->markLocation(9, 8);
        
        $overlappedLocations =$grid->getOverlapLocations($otherGrid);
        
        self::assertEquals(count($locationsToMark), count($overlappedLocations), "Should be same size");
        
       self::assertEquals($overlappedLocations, $locationsToMark, "Didn't return the same overlapped locations");
       
    }
    
    
    
    /**
     * Creates a grid object, if height/width aren't provided, creates a random sized one between 1 and
     * GridTest::MAX_DIMENSION
     *
     * @param int|null $height
     * @param int|null $width
     *
     * @return Grid
     * @throws PHPHelpersException
     */
    protected function createSUT(?int $height = null, ?int $width = null) : Grid {
        $eitherRandom = ($height === null || $width === null) ? true : false;
        $width        =
            ($width === null) ? TestHelpers::getRandomInt(self::MIN_DIMENSION, self::MAX_DIMENSION) : $width;
        $height       =
            ($height === null) ? TestHelpers::getRandomInt(self::MIN_DIMENSION, self::MAX_DIMENSION) : $height;
        
        if($eitherRandom === true) {
            //Try to get an unbalanced Grid as it will show more mistakes than a balanced one
            
            $tryAgainCounter = 100;
            while($width === $height && $tryAgainCounter > 0) {
                $tryAgainCounter--;
                $height = TestHelpers::getRandomInt(self::MIN_DIMENSION, self::MAX_DIMENSION);
            }
        }
        
        
        $sut = new Grid($width, $height);
    
        echo "Created New Grid of Size: " . $width . " x " . $height . PHP_EOL;
        return $sut;
    }
    
    
}
