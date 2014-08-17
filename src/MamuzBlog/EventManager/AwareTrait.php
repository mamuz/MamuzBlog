<?php

namespace MamuzBlog\EventManager;

use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerInterface;

trait AwareTrait
{
    /** @var EventManagerInterface */
    private $eventManager;

    /**
     * @param EventManagerInterface $eventManager
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;
    }

    /**
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (!$this->eventManager instanceof EventManagerInterface) {
            $this->setEventManager($this->createEventManager());
        }

        return $this->eventManager;
    }

    /**
     * @return EventManagerInterface
     */
    private function createEventManager()
    {
        return new EventManager(
            array_unique(
                array(
                    __CLASS__,
                    get_class($this),
                    Event::IDENTIFIER,
                )
            )
        );
    }

    /**
     * @param  string        $event
     * @param  array|object  $argv
     * @param  callable|null $callback
     * @return \Zend\EventManager\ResponseCollection
     */
    protected function trigger($event, $argv, $callback = null)
    {
        return $this->getEventManager()->trigger($event, $this, $argv, $callback);
    }
}
