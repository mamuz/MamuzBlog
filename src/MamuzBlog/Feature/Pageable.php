<?php

namespace MamuzBlog\Feature;

interface Pageable
{
    /**
     * @param int $currentPage
     * @return Pageable
     */
    public function setCurrentPage($currentPage);
}
