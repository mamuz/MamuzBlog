<?php

namespace MamuzBlog\Options;

class Range implements RangeInterface
{
    /** @var int */
    private $size;

    /**
     * @param int $size
     */
    public function __construct($size)
    {
        $this->size = (int) $size;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getOffsetBy($point)
    {
        return $this->size * ((int) $point - 1);
    }
}
