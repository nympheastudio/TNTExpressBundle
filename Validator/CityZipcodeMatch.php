<?php

/*
 * This file is part of the TNTExpress package.
 *
 * (c) Alexandre Bacco
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace winzou\Bundle\TNTExpressBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CityZipcodeMatch extends Constraint
{
    public $message        = "winzou.tnt_express.city_zipcode_match.message";
    public $invalidMessage = "winzou.tnt_express.city_zipcode_match.invalid_message";
    public $noCityMessage  = "winzou.tnt_express.city_zipcode_match.no_city_message";

    public $zipcode = 'zipcode';
    public $city    = 'city';

    public function validatedBy()
    {
        return 'winzou_tnt.city_zipcode_match';
    }

    public function getTargets()
    {
        return Constraint::CLASS_CONSTRAINT;
    }
}
