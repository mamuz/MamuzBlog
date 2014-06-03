<?php

namespace MamuzBlog\Options;

class Constraint implements ConstraintInterface
{
    /** @var array */
    private $specs = array();

    /** @var array */
    private $parameters = array();

    public function add($key, $spec, $value)
    {
        $this->parameters[$key] = $value;
        $this->specs[$key] = $spec;

        return $this;
    }

    public function isEmpty()
    {
        return empty($this->parameters);
    }

    public function toString()
    {
        return implode(' ', $this->specs);
    }

    public function toArray()
    {
        return $this->parameters;
    }
}
