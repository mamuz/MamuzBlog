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

    public function findPublishedPosts()
    {
        return $this->mapper->findPublishedPosts();
    }

    public function findPublishedPostsByTag($tag)
    {
        return $this->mapper->findPublishedPostsByTag($tag);
    }

    public function findPublishedPostById($id)
    {
        return $this->mapper->findPublishedPostById($id);
    }
}
