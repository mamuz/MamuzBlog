<?php

namespace MamuzBlog\View\Helper;

use MamuzBlog\Crypt\AdapterInterface;
use Zend\View\Helper\AbstractHelper;

class HashId extends AbstractHelper
{
    /** @var AdapterInterface */
    private $cryptEngine;

    /**
     * @param AdapterInterface $cryptEngine
     */
    public function __construct(AdapterInterface $cryptEngine)
    {
        $this->cryptEngine = $cryptEngine;
    }

    /**
     * {@link encrypt()}
     */
    public function __invoke($id)
    {
        return $this->encrypt($id);
    }

    /**
     * @param mixed $id
     * @return mixed string
     */
    public function encrypt($id)
    {
        return $this->cryptEngine->encrypt($id);
    }
}
