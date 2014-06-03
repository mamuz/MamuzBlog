<?php

namespace MamuzBlog\DomainManager;

interface ProviderInterface
{
    /**
     * @return array
     */
    public function getBlogDomainConfig();
}
