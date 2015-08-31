<?php

/*
 * This file is part of the TNTExpress package.
 *
 * (c) Alexandre Bacco
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace winzou\Bundle\TNTExpressBundle\Tracking;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use winzou\Bundle\TNTExpressBundle\Entity\Events;
use winzou\Bundle\TNTExpressBundle\Entity\ParcelResponse;

class DispatchTrackingManager
{
    /**
     * @var TrackingManager
     */
    protected $trackingManager;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    protected $propertyAccessor;

    public function __construct(TrackingManager $trackingManager, EventDispatcherInterface $dispatcher, PropertyAccessorInterface $propertyAccessor = null)
    {
        $this->trackingManager  = $trackingManager;
        $this->dispatcher       = $dispatcher;
        $this->propertyAccessor = $propertyAccessor ?: PropertyAccess::createPropertyAccessor();
    }

    /**
     * Update the events field of the given parcelResponse according to SOAP service response
     *
     * @param ParcelResponse $parcelResponse
     */
    public function updateEvents(ParcelResponse $parcelResponse)
    {
        $lastEvent = $parcelResponse->getEvents() ? $parcelResponse->getEvents()->getLastEvent() : Events::$sequence[0];

        $this->trackingManager->updateEvents($parcelResponse);

        if (null !== $parcelResponse->getEvents() && $lastEvent !== $parcelResponse->getEvents()->getLastEvent()) {
            $this->dispatchEvents($parcelResponse, $lastEvent);
        }
    }

    /**
     * Dispatch events for a given parcelResponse from a certain event to the last not null event
     *
     * @param ParcelResponse $parcelResponse
     * @param string|null    $fromEvent
     */
    public function dispatchEvents(ParcelResponse $parcelResponse, $fromEvent = null)
    {
        $genericEvent = new GenericEvent($parcelResponse);
        $startIndex   = array_search($fromEvent, Events::$sequence) ?: -1;

        foreach (Events::$sequence as $i => $event) {
            if ($i > $startIndex && $parcelResponse->getEvents()->isEventDone($event)) {
                $this->dispatcher->dispatch(
                    sprintf('winzou.tntexpress.events.%s', $event),
                    $genericEvent
                );
            }
        }
    }
}
