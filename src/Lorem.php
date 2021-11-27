<?php

/**
 * TOBENTO
 *
 * @copyright   Tobias Strub, TOBENTO
 * @license     MIT License, see LICENSE file distributed with this source code.
 * @author      Tobias Strub
 * @link        https://www.tobento.ch
 */

declare(strict_types=1);

namespace Tobento\Service\Seeder;

/**
 * Lorem
 */
class Lorem
{
    /**
     * @var array<int, string>
     */
    protected static array $words = [
        'ultricies', 'tristique', 'nulla', 'aliquet', 'enim', 'tortor', 'at', 'auctor', 'urna', 'nunc', 'id', 'cursus', 'metus', 'aliquam', 'eleifend', 'mi', 'in', 'nulla', 'posuere', 'sollicitudin', 'aliquam', 'ultrices', 'sagittis', 'orci', 'a', 'scelerisque', 'purus', 'semper', 'eget', 'duis', 'at', 'tellus', 'at', 'urna', 'condimentum', 'mattis', 'pellentesque', 'id', 'nibh', 'tortor', 'id', 'aliquet', 'lectus', 'proin', 'nibh', 'nisl', 'condimentum', 'id', 'venenatis', 'a', 'condimentum', 'vitae', 'sapien', 'pellentesque', 'habitant', 'morbi', 'tristique', 'senectus', 'et', 'netus', 'et', 'malesuada', 'fames', 'ac', 'turpis', 'egestas', 'sed', 'tempus', 'urna', 'et', 'pharetra', 'pharetra', 'massa', 'massa', 'ultricies', 'mi', 'quis', 'hendrerit', 'dolor', 'magna', 'eget', 'est', 'lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur', 'adipiscing', 'elit', 'pellentesque', 'habitant', 'morbi', 'tristique', 'senectus', 'et', 'netus', 'et', 'malesuada', 'fames'
    ];
    
    /**
     * Returns random word in lowercase.
     *
     * @param int $number
     * @param string $separator
     * @return string
     */
    public static function word(int $number = 1, string $separator = ' '): string
    {
        $words = static::$words;
        $wordsCount = count($words);
        
        shuffle($words);
        $words= array_slice($words, 0, $number);
        $string = implode($separator, $words);
        
        if ($wordsCount < $number) {
            return $string.static::words($number-$wordsCount);
        }
        
        return $string;
    }
    
    /**
     * Returns random words between the min and max words specified in lowercase.
     *
     * @param int $minWords
     * @param int $maxWords
     * @param string $separator
     * @return string
     */
    public static function words(int $minWords = 1, int $maxWords = 10, string $separator = ' '): string
    {
        return static::word(Num::int($minWords, $maxWords), $separator);
    }    

    /**
     * Returns a random sentence.
     *
     * @param int $number
     * @return string
     */
    public static function sentence(int $number = 1): string
    {
        $sentence = '';
        
        for ($i = 1; $i <= $number; $i++) {
            
            $sentence .= ' ';
            
            if (Num::bool()) {
                // with comma
                $sentence .= ucfirst(static::word(Num::int(3, 10)));
                $sentence .= ', '.static::word(Num::int(3, 10)).'.';
            } else {
                $sentence .= ucfirst(static::word(Num::int(3, 15))).'.';
            }
        }
        
        return ltrim($sentence, ' ');
    }
    
    /**
     * Returns a random slug between the min and max words specified.
     *
     * @param int $minWords
     * @param int $maxWords
     * @return string
     */
    public static function slug(int $minWords = 1, int $maxWords = 10): string
    {
        return static::words($minWords, $maxWords, '-');
    }   
}