<?php

namespace Sysatom;

/**
 * Class BitMap
 * @package Sysatom
 */
class BitMap
{
    /**
     * @var
     */
    private $fn;

    /**
     * @var integer $size file size
     */
    private $size;

    /**
     * BitMap constructor.
     * @param $length
     */
    public function __construct()
    {
        $temp_file = tempnam(sys_get_temp_dir(), 'BitMap');
        $this->fn = fopen($temp_file, file_exists($temp_file) ? 'r+' : 'w+');
        clearstatcache(true, $temp_file);
        $this->size = filesize($temp_file);
    }

    /**
     * @param $offset
     * @param $value
     * @return bool
     */
    public function setBit($offset, $value)
    {
        if ($value !== 0 && $value !== 1) {
            return false;
        }
        if ($offset > $this->size * 8) {
            $this->append($offset);
        }
        fseek($this->fn, ceil($offset / 8) - 1);
        $byte = fread($this->fn, 1);
        $mask = pack('C', 256 >> (fmod($offset - 1, 8) + 1));
        fseek($this->fn, ftell($this->fn) - 1);
        $res = $value ? ($byte | $mask) : ($byte & ~$mask);
        fwrite($this->fn, $res);
        return fflush($this->fn);
    }

    /**
     * @param $offset
     * @return bool|int
     */
    public function getBit($offset)
    {
        if (fseek($this->fn, ceil($offset / 8) - 1)) {
            return false;
        }
        $byte = fread($this->fn, 1);
        $res = $byte & pack('C', 256 >> (fmod($offset - 1, 8) + 1));
        return (!$res || $res === "\0") ? 0 : 1;
    }

    /**
     * @return int
     */
    public function bitCount()
    {
        $count = 0;
        rewind($this->fn);
        while (!feof($this->fn)) {
            $bytes = fread($this->fn, pow(2, 20));
            foreach (unpack('C*', $bytes) as $bin) {
                while ($bin) {
                    $count++;
                    $bin &= ($bin - 1);
                }
            }
        }
        return $count;
    }

    /**
     * @param $offset
     */
    private function append($offset)
    {
        fseek($this->fn, 0, SEEK_END);
        list($size, $step) = [ceil($offset / 8), pow(2, 20)];
        $append = $size - $this->size;
        $value = str_repeat("\0", $step);
        for ($n = 0; $n < floor($append / $step); $n++) {
            fwrite($this->fn, $value);
        }
        fwrite($this->fn, str_repeat("\0", $append % $step));
        $this->size = $size;
    }

    /**
     * destruct
     */
    public function __destruct()
    {
        fclose($this->fn);
    }
}
