<?php


namespace App\Listener;


use App\Event\AdCreatedEvent;

class AdListener
{
    public function onCreatedAdEvent (AdCreatedEvent $event)
    {
        // TODO create logic here, I would store ads on que to process social network posts on each time it's created
        // since there are multiple social network posts and we don't know how quick they will be, it is best to store
        // them in the que and run them separately
    }
}
