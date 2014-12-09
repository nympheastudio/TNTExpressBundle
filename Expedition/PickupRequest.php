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

use winzou\Bundle\TNTExpressBundle\Repository\ExpeditionRepository;

class PickupRequest
{
    /**
     * @var ExpeditionRepository
     */
    protected $repository;

    public function __construct(ExpeditionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function isPickupRequestNeeded(\Datetime $date = null)
    {
        if (null === $date) {
            $date = new \Datetime();
        }

        return ! $this->repository->hasRequestOnDate($date);
    }
}
