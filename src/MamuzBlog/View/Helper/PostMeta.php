<?php

namespace MamuzBlog\View\Helper;

use MamuzBlog\Entity\Post as PostEntity;

class PostMeta extends AbstractHelper
{
    /**
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
        $html = '<div style="border-top:1px solid white">' . PHP_EOL
            . $this->getRenderer()->dateFormat($entity->getModifiedAt()) . PHP_EOL
            . $this->buildBadges($entity->getTags()) . PHP_EOL
            . '</div>';

        return $html;
    }

    private function buildBadges(array $tags)
    {
        $html = '';

        foreach ($tags as $tag) {
            /** @var \MamuzBlog\Entity\Tag $tag */
            $tagName = $tag->getName();
            $url = $this->getRenderer()->url(
                'blogActivePosts',
                array('tag' => $tagName)
            );
            $tagNameTranslated = $this->getRenderer()->translate($tagName);
            $badge = $this->getRenderer()->badge($tagNameTranslated);
            $html .= '<a title="' . $tagNameTranslated . '" href="' . $url . '"> ' . $badge . ' </a>' . PHP_EOL;
        }

        return $html;
    }
}
