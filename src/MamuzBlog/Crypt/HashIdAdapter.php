<?php

namespace MamuzBlog\Crypt;

use Hashids\Hashids;

class HashIdAdapter implements AdapterInterface
{
    /** @var Hashids */
    private $hashIds;

    public function __construct(HashIds $hashIds)
    {
        $this->hashIds = $hashIds;
    }

    public function decrypt($value)
    {
        return $this->hashIds->decrypt($value)[0];
    }

    public function encrypt($value)
    {
        return $this->hashIds->encrypt($value);
    }
}
