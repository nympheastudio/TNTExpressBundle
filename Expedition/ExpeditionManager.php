<?php

/*
 * This file is part of the TNTExpress package.
 *
 * (c) Alexandre Bacco
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace winzou\Bundle\TNTExpressBundle\Expedition;

use TNTExpress\Client\TNTClientInterface;
use winzou\Bundle\TNTExpressBundle\Entity\ExpeditionRequest;

class ExpeditionManager
{
    protected $client;
    protected $pickupRequest;

    public function __construct(TNTClientInterface $client, PickupRequest $pickupRequest)
    {
        $this->client = $client;
        $this->pickupRequest = $pickupRequest;
    }

    public function createExpedition(ExpeditionRequest $expeditionRequest, $serviceCodeFilter = null)
    {
        if (null === $expeditionRequest->getServiceCode()) {
            $feasibility = $this->client->getFeasibility($expeditionRequest, $serviceCodeFilter);
            $expeditionRequest->setServiceCode($feasibility[0]->getServiceCode());
        }

        if (!$this->pickupRequest->isPickupRequestNeeded($expeditionRequest->getShippingDate())
            && null !== $expeditionRequest->getPickupRequest()
        ) {
            $expeditionRequest->setPickupRequest(null);
        }

        $expedition = $this->client->createExpedition($expeditionRequest);
        $expedition->setExpeditionRequest($expeditionRequest);

        return $expedition;
    }
}
