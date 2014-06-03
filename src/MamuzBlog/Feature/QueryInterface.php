<?php

namespace MamuzBlog\Feature;

use MamuzBlog\Entity\Post;

interface QueryInterface
{
    /**
     * @param int $currentPage
     * @return QueryInterface
     */
    public function setCurrentPage($currentPage);

    /**
     * @return Post[]
     */
    public function findActivePosts();

    /**
     * @param string $tag
     * @return Post[]
     */
    public function findActivePostsByTag($tag);

    /**
     * @param string|integer $id
     * @return Post|null
     */
    public function findActivePostById($id);
}
