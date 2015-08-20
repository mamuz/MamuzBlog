<?php

namespace MamuzBlog\View\Helper;

use MamuzBlog\Entity\Post as PostEntity;

class PostPanel extends AbstractHelper
{
    /** @var PostEntity */
    protected $entity;

    /** @var string */
    protected $header;

    /** @var string */
    protected $content;

    /** @var string */
    protected $footer;

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
        $this->entity = $entity;

        $this->createHeader();
        $this->createContent();
        $this->createFooter();

        return $this->getRenderer()->panel($this->header, $this->content, $this->footer);
    }

    /**
     * @return void
     */
    protected function createHeader()
    {
        $this->header = $this->entity->getTitle();
    }

    /**
     * @return void
     */
    protected function createContent()
    {
        $this->content = $this->getRenderer()->markdown($this->entity->getContent());
    }

    /**
     * @return void
     */
    protected function createFooter()
    {
        $this->footer = $this->getRenderer()->postMeta($this->entity);
    }
}
