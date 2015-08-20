<?php

namespace MamuzBlog\View\Helper;

use MamuzBlog\Entity\Post as PostEntity;

class PostMeta extends AbstractHelper
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
        $html = '<span>' . $this->createDate($entity->getModifiedAt()) . '</span>' . PHP_EOL
            . '<span class="pull-right">' . $this->createBadges($entity->getTags()) . '</span>';

        return $html;
    }

    /**
     * @param \DateTime $dateTime
     * @return string
     */
    protected function createDate(\DateTime $dateTime)
    {
        $dateString = $this->getRenderer()->dateFormat(
            $dateTime,
            \IntlDateFormatter::LONG,
            \IntlDateFormatter::NONE
        );

        $html = $this->getRenderer()->glyphicon('calendar')
            . '<time datetime="' . $dateTime->format('Y-m-d') . '">'
            . $dateString
            . '</time>';

        return $html;
    }

    /**
     * @param \Traversable $tags
     * @return string
     */
    protected function createBadges(\Traversable $tags)
    {
        $html = '';

        foreach ($tags as $tag) {
            /** @var \MamuzBlog\Entity\Tag $tag */
            $tagName = $tag->getName();
            $content = $this->getRenderer()->badge($this->getRenderer()->translate($tagName));
            $html .= $this->getRenderer()->tagAnchor($tagName, $content) . PHP_EOL;
        }

        return $html;
    }
}
