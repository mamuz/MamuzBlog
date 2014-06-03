<?php

namespace MamuzBlog\Service;

use MamuzBlog\Feature\QueryInterface;

class Query implements QueryInterface
{
    /** @var QueryInterface */
    private $mapper;

    /**
     * @param QueryInterface $mapper
     */
    public function __construct(QueryInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    public function setCurrentPage($currentPage)
    {
        $this->mapper->setCurrentPage($currentPage);
        return $this;
    }

    public function findActivePosts()
    {
        return $this->mapper->findActivePosts();
    }

    public function findActivePostsByTag($tag)
    {
        return $this->mapper->findActivePostsByTag($tag);
    }

    public function findActivePostById($id)
    {
        return $this->mapper->findActivePostById($id);
    }
}
