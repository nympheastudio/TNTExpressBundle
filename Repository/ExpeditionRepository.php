<?php

/*
 * This file is part of the TNTExpress package.
 *
 * (c) Alexandre Bacco
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace winzou\Bundle\TNTExpressBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ExpeditionRepository extends EntityRepository
{
    public function hasRequestOnDate(\Datetime $date = null)
    {
        if (null === $date) {
            $date = new \Datetime();
        }

        return (bool) $this->_em->createQueryBuilder('e')
            ->select('COUNT(e)')
            ->from('winzouTNTExpressBundle:Expedition', 'e')
            ->join('e.expeditionRequest', 'er')
            ->where('e.pickUpNumber IS NOT NULL')
            ->andWhere('DATE_DIFF(er.shippingDate, :date) = 0')
            ->setParameter('date', $date)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
