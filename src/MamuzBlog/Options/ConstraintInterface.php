<?php

namespace MamuzBlog\Options;

interface ConstraintInterface
{
    /**
     * @param string $key
     * @param string $spec
     * @param mixed  $value
     * @return ConstraintInterface
     */
    public function add($key, $spec, $value);

    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @return string
     */
    public function toString();

    /**
     * @return array
     */
    public function toArray();
}
