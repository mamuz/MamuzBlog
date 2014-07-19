<?php

namespace MamuzBlog\View\Helper;

use MamuzBlog\Entity\Post as PostEntity;
use Zend\View\Helper\AbstractHelper;

class PostPanel extends AbstractHelper
{
    /**
     * {@link render()}
     */
    public function __invoke(PostEntity $entity, $headerLink = true)
    {
        return $this->render($entity, $headerLink);
    }

    /**
     * @param PostEntity $entity
     * @param bool       $headerLink
     * @return string
     */
    public function render(PostEntity $entity, $headerLink = true)
    {
        $header = $entity->getTitle();

        if ($headerLink) {
            $url = $this->getRenderer()->url(
                'blogActivePost',
                array(
                    'title' => $entity->getTitle(),
                    'id'    => $this->getRenderer()->hashId($entity->getId())
                )
            );
            $header = '<a href="' . $url . '">' . $header . '</a>';
        }

        $html = '<h3>' . $header . '</h3>' . PHP_EOL
            . '<div class="well">' . PHP_EOL
            . $this->getRenderer()->markdown($entity->getContent()) . PHP_EOL
            . '</div>';

        return $html;
    }

    /**
     * @return \MamuzBlog\View\Renderer\PhpRenderer
     */
    private function getRenderer()
    {
        return $this->getView();
    }
}
