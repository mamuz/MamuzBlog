<?php

namespace MamuzBlog\Feature;

use MamuzBlog\Entity\Post;

interface PostQueryInterface extends Pageable
{
    /**
     * @return Post[]|\Countable|\IteratorAggregate
     */
    public function findActivePosts();

    /**
     * @param string $tag
     * @return Post[]|\Countable|\IteratorAggregate
     */
    public function findActivePostsByTag($tag);

    /**
     * @param string|integer $id
     * @return Post|null
     */
    public function findActivePostById($id);
}
