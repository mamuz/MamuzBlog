<?php

namespace MamuzBlog\Crypt;

interface AdapterInterface
{
    /**
     * @param mixed $value
     * @return mixed
     */
    public function decrypt($value);

    /**
     * @param mixed $value
     * @return mixed
     */
    public function encrypt($value);
}
