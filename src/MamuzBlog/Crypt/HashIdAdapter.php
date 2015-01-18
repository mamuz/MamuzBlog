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
        $decryption = $this->hashIds->decode($value);

        if (isset($decryption[0])) {
            return $decryption[0];
        }
        
        return null;
    }

    public function encrypt($value)
    {
        return $this->hashIds->encode($value);
    }
}
