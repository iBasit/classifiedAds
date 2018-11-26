<?php


namespace App\Event;


use App\Entity\Ad;
use Symfony\Component\EventDispatcher\Event;

/**
 * The ads.created event is dispatched each time an ads is created
 * in the system.
 */
class AdCreatedEvent extends Event
{
    const NAME = 'ads.created';

    /**
     * @var Ad
     */
    protected $ad;

    /**
     * DeliveryCreatedEvent constructor.
     * @param Ad $user
     */
    public function __construct(Ad $ad)
    {
        $this->ad = $ad;
    }

    /**
     * @return Ad
     */
    public function getAd(): Ad
    {
        return $this->ad;
    }
}
