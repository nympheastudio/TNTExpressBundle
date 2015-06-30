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

use TNTExpress\Model\ParcelResponse as BaseParcelResponse;
use TNTExpress\Model\Events as BaseEvents;

class ParcelResponse extends BaseParcelResponse
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Expedition
     */
    protected $expedition;

    /**
     * @var BaseEvents
     */
    protected $events;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Expedition
     */
    public function getExpedition()
    {
        return $this->expedition;
    }

    /**
     * @param Expedition $expedition
     * @return $this
     */
    public function setExpedition(Expedition $expedition)
    {
        $this->expedition = $expedition;

        return $this;
    }

    /**
     * @return BaseEvents
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param BaseEvents $events
     * @return $this
     */
    public function setEvents(BaseEvents $events)
    {
        $this->events = $events;

        return $this;
    }
}
