<?php

namespace Sysatom;

use lastguest\Murmur;

/**
 * Class BloomFilter
 *
 * @package Sysatom
 */
class BloomFilter
{
    /**
     * @var integer Bitmap size
     */
    private $size;

    /**
     * @var integer hash size
     */
    private $hashCount;

    /**
     * @var BitMap $bitMap
     */
    private $bitMap;

    /**
     * BloomFilter constructor.
     * @param $size
     * @param $hashCount
     */
    public function __construct($size, $hashCount)
    {
        $this->size = $size;
        $this->hashCount = $hashCount;
        $this->bitMap = new BitMap();
    }

    /**
     * Add item
     *
     * @param string $string
     */
    public function add($string)
    {
        for ($seed = 0; $seed < $this->hashCount; $seed++) {
            $res = Murmur::hash3_int($string, $seed) % $this->size;
            $this->bitMap->setBit($res, 1);
        }
    }

    /**
     * lookup item
     *
     * @param $string
     * @return bool
     */
    public function lookup($string)
    {
        for ($seed = 0; $seed < $this->hashCount; $seed++) {
            $res = Murmur::hash3_int($string, $seed) % $this->size;
            if ($this->bitMap->getBit($res) == 0) {
                return false;
            }
        }
        return true;
    }
}
