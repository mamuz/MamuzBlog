<?php

namespace MamuzBlog\View\Helper;

use MamuzBlog\Entity\Tag as TagEntity;

class Tag extends AbstractHelper
{
    /**
     * {@inheritdoc}
     * {@link render()}
     */
    public function __invoke(TagEntity $entity)
    {
        return $this->render($entity);
    }

    /**
     * @param TagEntity $entity
     * @return string
     */
    public function render(TagEntity $entity)
    {
        if ($postCount = count($entity->getPosts())) {
            $tagName = $entity->getName();
            $content = $this->getRenderer()->badge($postCount, array('class' => 'pull-right'))
                . $this->getRenderer()->translate($tagName);
            return $this->getRenderer()->tagAnchor($tagName, $content);
        }

        return '';
    }
}
