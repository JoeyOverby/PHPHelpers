<?php declare(strict_types = 1);
/**
 * Created by Joey Overby
 * Repositories: https://github.com/JoeyOverby
 * Date: 12/3/19
 */

namespace JoeyOverby\PHPHelpers\Test;

use Faker\Generator;


/**
 * Class TestHelpers
 *
 * A collection of testing helper functions!
 *
 * @package JoeyOverby\PHPHelpers\Test
 */
class TestHelpers {
    
    
    /**
     * @var Generator|null
     */
    protected static ?Generator $faker = null;
    
    /**
     * Returns random integer between min and max, or 0 and PHP_INT_MAX if not specified
     *
     * @param int $min - Minimum value for the random integer
     * @param int $max - Maximum value for the random integer
     *
     * @return int
     */
    public static function getRandomInt(int $min = 0, int $max = PHP_INT_MAX) : int {
        return intval(self::getFaker()->numberBetween($min, $max));
    }
    
    /**
     * Returns a faker/generator
     * @return Generator
     */
    protected static function getFaker() : Generator{
        if(self::$faker === null){
            self::$faker = \Faker\Factory::create();
        }
        
        return self::$faker;
    }
    
}