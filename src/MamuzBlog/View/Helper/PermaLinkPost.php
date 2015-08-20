<?php

namespace MamuzBlog\View\Helper;

use MamuzBlog\Entity\Post as PostEntity;

class PermaLinkPost extends AbstractHelper
{
    /**
     * {@inheritdoc}
     * {@link render()}
     */
    public function __invoke(PostEntity $entity)
    {
        return $this->render($entity);
    }

    /**
     * @param PostEntity $entity
     * @return string
     */
    public function render(PostEntity $entity)
    {
        $serverUrl = $this->getRenderer()->serverUrl();

        $url = $this->getRenderer()->url(
            'blogPublishedPost',
            array(
                'title' => $this->getRenderer()->slugify($entity->getTitle()),
                'id'    => $this->getRenderer()->hashId($entity->getId())
            )
        );

        return $serverUrl . $url;
    }
}
