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

use TNTExpress\Model\Expedition as BaseExpedition;

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
     * @var \Datetime
     */
    protected $createdAt;

    public function getId()
    {
        return $this->id;
    }

    public function setShippingDate(\Datetime $shippindDate)
    {
        $this->shippindDate = $shippindDate;

        return $this;
    }

    public function getShippindDate()
    {
        return $this->shippindDate;
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

    public function setCreatedAt(\Datetime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
