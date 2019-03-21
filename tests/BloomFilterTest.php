<?php

use PHPUnit\Framework\TestCase;

/**
 * Class BloomFilterTest
 */
class BloomFilterTest extends TestCase
{
    /**
     * BloomFilter Test case
     */
    public function testBloomFilter()
    {
        $bf = new \Sysatom\BloomFilter(100000, 7);
        for ($i = 1; $i <= 5000; $i++) {
            $bf->add("$i");
        }
        $this->assertTrue($bf->lookup('42'));
        $this->assertTrue($bf->lookup('5000'));
        $this->assertFalse($bf->lookup('100000'));
        $this->assertFalse($bf->lookup('500001'));
    }

    /**
     * BitMap Test case
     */
    public function testBitMap()
    {
        $bm = new \Sysatom\BitMap();
        for ($i = 1; $i <= 1000; $i++) {
            $bm->setBit($i, 1);
        }
        $this->assertEquals($bm->bitCount(), 1000);

        $this->assertFalse($bm->setBit(2000, 2));
        $this->assertFalse($bm->getBit(0));
    }

}
