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

use TNTExpress\Client\TNTClientInterface;
use winzou\Bundle\TNTExpressBundle\Entity\Events;
use winzou\Bundle\TNTExpressBundle\Entity\ParcelResponse;

class TrackingManager
{
    /**
     * @var TNTClientInterface
     */
    protected $client;

    public function __construct(TNTClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Update the events field of the given parcelResponse according to SOAP service response
     *
     * @param ParcelResponse $parcelResponse
     */
    public function updateEvents(ParcelResponse $parcelResponse)
    {
        $events = $this
            ->client
            ->getTrackingByConsignment($parcelResponse->getParcelNumber())
            ->getEvents()
        ;

        $this->mergeEvents($parcelResponse->getEvents(), $events);
    }

    /**
     * Merge the values of $e2 in $e1
     *
     * @param Events $e1
     * @param Events $e2
     */
    protected function mergeEvents(Events $e1, Events $e2)
    {
        $ro = new \ReflectionObject($e1);

        foreach ($ro->getProperties(\ReflectionProperty::IS_PROTECTED) as $rp) {
            $rp->setAccessible(true);
            $newValue = $rp->getValue($e2);

            if (!$rp->getValue($e1) && $newValue) {
                $rp->setValue($e1, $newValue);
            }
        }
    }
}
