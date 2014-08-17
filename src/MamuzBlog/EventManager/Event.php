<?php

namespace MamuzBlog\EventManager;

interface Event
{
    const IDENTIFIER = 'mamuz-blog';

    const PRE_PAGINATION_CREATE = 'createPaginator.pre';

    const POST_PAGINATION_CREATE = 'createPaginator.post';

    const PRE_FIND_PUBLISHED_POST = 'findPublishedPost.pre';

    const POST_FIND_PUBLISHED_POST = 'findPublishedPost.post';
}
