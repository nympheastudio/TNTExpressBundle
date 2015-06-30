<?php

/*
 * This file is part of the TNTExpress package.
 *
 * (c) Alexandre Bacco
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace winzou\Bundle\TNTExpressBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use TNTExpress\Model\Expedition as BaseExpedition;
use TNTExpress\Model\ParcelResponse;

class Expedition extends BaseExpedition
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var ExpeditionRequest
     */
    protected $expeditionRequest;

    /**
     * @var Events
     */
    protected $events;

    /**
     * @var \Datetime
     */
    protected $createdAt;

    /**
     * @var \Datetime
     */
    protected $shippingDate;

    public function __construct()
    {
        $this->parcelResponses = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setShippingDate(\Datetime $shippingDate)
    {
        $this->shippingDate = $shippingDate;

        return $this;
    }

    public function getShippingDate()
    {
        return $this->shippingDate;
    }

    public function setExpeditionRequest(ExpeditionRequest $expeditionRequest)
    {
        $this->expeditionRequest = $expeditionRequest;

        return $this;
    }

    public function getExpeditionRequest()
    {
        return $this->expeditionRequest;
    }

    public function setEvents(Events $events)
    {
        $this->events = $events;

        return $this;
    }

    public function getEvents()
    {
        return $this->events;
    }

    public function setCreatedAt(\Datetime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function addParcelResponse(ParcelResponse $parcelResponse)
    {
        $parcelResponse->setExpedition($this);

        return parent::addParcelResponse($parcelResponse);
    }
}
