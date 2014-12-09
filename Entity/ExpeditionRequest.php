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

use TNTExpress\Model\ExpeditionRequest as BaseExpeditionRequest;

class ExpeditionRequest extends BaseExpeditionRequest
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var \Datetime
     */
    protected $createdAt;

    public function getId()
    {
        return $this->id;
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
