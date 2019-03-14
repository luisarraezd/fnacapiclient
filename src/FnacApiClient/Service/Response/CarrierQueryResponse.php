<?php
/*
 * This file is part of the fnacApi.
 * (c) 2011 Fnac
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FnacApiClient\Service\Response;

use FnacApiClient\Entity\Carrier;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * BatchQueryResponse service base definition for batch query response
 *
 * @author     Fnac
 * @version    1.0.0
 */
class CarrierQueryResponse extends ResponseService
{
    /** @var \ArrayObject|Carrier[] */
    private $carriers;

    /**
     * {@inheritdoc}
     */
    public function denormalize(DenormalizerInterface $denormalizer, $data, $format = null, array $context = array())
    {
        parent::denormalize($denormalizer, $data, $format);

        $this->carriers = new \ArrayObject();
        foreach ($data['carrier'] as $carrier) {
            $carrObj = new Carrier();
            $carrObj->denormalize($denormalizer, $carrier, $format);
            $this->carriers[] = $carrObj;
        }
    }

    /**
     * @return \ArrayObject|Carrier[]
     */
    public function getCarriers()
    {
        return $this->carriers;
    }
}
