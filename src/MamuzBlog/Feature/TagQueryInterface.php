<?php

namespace MamuzBlog\Feature;

use MamuzBlog\Entity\Tag;

interface TagQueryInterface extends Pageable
{
    /**
     * @return Tag[]|\Countable|\IteratorAggregate
     */
    public function findUsedTags();
}
