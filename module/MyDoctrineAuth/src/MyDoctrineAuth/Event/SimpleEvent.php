<?php
namespace MyDoctrineAuth\Event;
class SimpleEvent
{
    /* @var \Zend\EventManager\EventManagerInterface */
    protected $eventManager;
    public function getEventManager()
    {
        if(!$this->eventManager instanceof \Zend\EventManager\EventManagerInterface){
            $this->eventManager = new \Zend\EventManager\EventManager();
        }
        return $this->eventManager;
    }
    public function echoHello()
    {
        $this->getEventManager()->trigger(__FUNCTION__."_pre", $this);
        echo "Hello";
        $this->getEventManager()->trigger(__FUNCTION__."_post", $this);
    }
}