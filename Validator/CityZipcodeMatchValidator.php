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

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use TNTExpress\Client\TNTClientInterface;
use TNTExpress\Exception\InvalidZipcodeException;
use TNTExpress\Exception\InvalidPairZipcodeCityException;
use TNTExpress\Exception\ClientException;
use TNTExpress\Model\City;

class CityZipcodeMatchValidator extends ConstraintValidator
{
    /**
     * @var TNTClientInterface
     */
    protected $client;

    protected $cache = array();

    public function __construct(TNTClientInterface $client)
    {
        $this->client = $client;
    }

    public function validate($value, Constraint $constraint)
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $zipcode = $accessor->getValue($value, $constraint->zipcode);

        if (isset($this->cache[$zipcode])) {
            $this->addViolation($this->cache[$zipcode]);

            return;
        }

        $city = $accessor->getValue($value, $constraint->city);

        try {
            try {
                $this->client->getDropOffPoints($zipcode, $city);
            } catch (InvalidPairZipcodeCityException $e) {
                $cities = $this->client->getCitiesGuide($zipcode);
                $this->cache[$zipcode] = array('message' => $constraint->message, 'path' => $constraint->city, 'parameters' => array('%cities%' => implode(array_map(array($this, 'transformCityToName'), $cities), ', ')));
            }
        } catch (InvalidZipcodeException $e) {
            $this->cache[$zipcode] = array('message' => $constraint->invalidMessage, 'path' => $constraint->zipcode);
        } catch (ClientException $e) {
            $this->cache[$zipcode] = array('message' => $constraint->noCityMessage, 'path' => $constraint->zipcode);
        }

        if (isset($this->cache[$zipcode])) {
            $this->addViolation($this->cache[$zipcode]);
        }
    }

    protected function addViolation($cache)
    {
        $this->context
            ->buildViolation($cache['message'])
            ->atPath($cache['path'])
            ->setParameters(isset($cache['parameters']) ? $cache['parameters'] : array())
            ->addViolation()
        ;
    }

    protected function transformCityToName(City $city)
    {
        return ucwords(strtolower($city->getName()));
    }
}
