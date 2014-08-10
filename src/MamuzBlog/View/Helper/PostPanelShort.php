<?php

namespace MamuzBlog\View\Helper;

class PostPanelShort extends PostPanel
{
    /** @var string */
    private $url;

    private function getUrl()
    {
        if (!is_string($this->url)) {
            $this->createUrl();
        }
        return $this->url;
    }

    private function createUrl()
    {
        $this->url = $this->getRenderer()->url(
            'blogPublishedPost',
            array(
                'title' => $this->getRenderer()->slugify($this->entity->getTitle()),
                'id'    => $this->getRenderer()->hashId($this->entity->getId())
            )
        );
    }

    /**
     * @return void
     */
    protected function createHeader()
    {
        $this->header = $this->getRenderer()->anchor($this->getUrl(), 'Go to post', $this->entity->getTitle());
    }

    /**
     * @return void
     */
    protected function createContent()
    {
        $this->content = $this->getRenderer()->markdown($this->entity->getDescription())
            . $this->getRenderer()->anchor($this->getUrl(), 'Go to post', 'Read more');
    }
}
