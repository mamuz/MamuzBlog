<?php

namespace MamuzBlog\Feature;

use MamuzBlog\Entity\Tag;

interface TagQueryInterface
{
    /**
     * @param int $currentPage
     * @return TagQueryInterface
     */
    public function setCurrentPage($currentPage);

    /**
     * @return Tag[]
     */
    public function findTags();
}
