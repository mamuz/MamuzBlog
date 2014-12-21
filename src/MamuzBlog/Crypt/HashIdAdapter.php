<?php

namespace MamuzBlog\Crypt;

use Hashids\Hashids;

class HashIdAdapter implements AdapterInterface
{
    /** @var Hashids */
    private $hashIds;

    public function __construct(Hashids $hashIds)
    {
        $this->hashIds = $hashIds;
    }

    public function decrypt($value)
    {
        return $this->hashIds->decode($value)[0];
    }

    public function encrypt($value)
    {
        return $this->hashIds->encode($value);
    }
}
