<?php

namespace MamuzBlog\Service;

use MamuzBlog\Feature\TagQueryInterface;

class TagQuery implements TagQueryInterface
{
    /** @var TagQueryInterface */
    private $mapper;

    /**
     * @param TagQueryInterface $mapper
     */
    public function __construct(TagQueryInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    public function setCurrentPage($currentPage)
    {
        $this->mapper->setCurrentPage($currentPage);
        return $this;
    }

    public function findUsedTags()
    {
        return $this->mapper->findUsedTags();
    }
}
