<?php

namespace MamuzBlog\Service;

use MamuzBlog\Feature\PostQueryInterface;

class PostQuery implements PostQueryInterface
{
    /** @var PostQueryInterface */
    private $mapper;

    /**
     * @param PostQueryInterface $mapper
     */
    public function __construct(PostQueryInterface $mapper)
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
