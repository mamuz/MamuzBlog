<?php

namespace MamuzBlog\Feature;

use MamuzBlog\Entity\Post;

interface PostQueryInterface extends Pageable
{
    /**
     * @return Post[]|\Countable|\IteratorAggregate
     */
    public function findPublishedPosts();

    /**
     * @param string $tag
     * @return Post[]|\Countable|\IteratorAggregate
     */
    public function findPublishedPostsByTag($tag);

    /**
     * @param string|integer $id
     * @return Post|null
     */
    public function findPublishedPostById($id);
}
