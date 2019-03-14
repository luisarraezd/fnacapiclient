<?php
/*
 * This file is part of the fnacMarketPlace APi Client.
 * (c) 2011 Fnac
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FnacApiClient\Entity;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * OrderDetailUpdate definition.
 *
 * @author     Fnac
 * @version    1.0.0
 */

class OrderDetailUpdate extends Entity
{
    /** @var int */
    private $order_detail_id;

    /** @var string */
    private $status;

    /** @var string */
    private $state;

    /** @var \ArrayObject|Error[] */
    private $errors;

    /**
     * {@inheritDoc}
     */
    public function normalize(NormalizerInterface $normalizer, $format = null, array $context = array())
    {

    }

    /**
     * {@inheritDoc}
     */
    public function denormalize(DenormalizerInterface $denormalizer, $data, $format = null, array $context = array())
    {
        $this->order_detail_id = $data['order_detail_id'];
        $this->status = $data['status'];
        $this->state = isset($data['state']) ? $data['state'] : "";

        $this->errors = new \ArrayObject();

        if (isset($data['error'])) {
            if (isset($data['error'][0])) {
                foreach ($data['error'] as $error) {
                    $tmpObj = new Error();
                    $tmpObj->denormalize($denormalizer, $error, $format);
                    $this->errors[] = $tmpObj;
                }
            } else {
                $tmpObj = new Error();
                $tmpObj->denormalize($denormalizer, $data['error'], $format);
                $this->errors[] = $tmpObj;
            }
        }
    }

    /**
     * Order detail unique identifier (fnac one)
     *
     * @return integer
     */
    public function getOrderDetailId()
    {
        return $this->order_detail_id;
    }

    /**
     * Order detail state
     *
     * @see \FnacApiClient\Type\OrderDetailStateType
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Order detail update status
     *
     * @see \FnacApiClient\Type\ResponseStatusType
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return \ArrayObject|Error[]
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
