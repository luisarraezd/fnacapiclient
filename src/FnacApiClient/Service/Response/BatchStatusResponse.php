<?php
/*
 * This file is part of the fnacApi.
 * (c) 2011 Fnac
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FnacApiClient\Service\Response;

use FnacApiClient\Entity\Error;
use FnacApiClient\Entity\OfferUpdate;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * BatchStatusResponse service base definition for batch status response.
 *
 * @author     Fnac
 * @version    1.0.0
 */
class BatchStatusResponse extends ResponseService
{
    /** @var string */
    private $batch_id;

    /** @var \ArrayObject|Error[] */
    private $errors;

    /** @var \ArrayObject|OfferUpdate[] */
    private $offers;

    /**
     * {@inheritdoc}
     */
    public function denormalize(DenormalizerInterface $denormalizer, $data, $format = null, array $context = array())
    {
        parent::denormalize($denormalizer, $data, $format);

        $this->batch_id = isset($data['batch_id']) ? $data['batch_id'] : "";

        $this->errors = new \ArrayObject();

        if (isset($data['error'])) {
            if (isset($data['error'][0])) {
                foreach ($data['error'] as $error) {
                    $tmpObj = new Error();
                    $tmpObj->denormalize($denormalizer, $error, $format);
                    $this->errors[] = $tmpObj;
                }
            } elseif (!empty($data['error'])) {
                $tmpObj = new Error();
                $tmpObj->denormalize($denormalizer, $data['error'], $format);
                $this->errors[] = $tmpObj;
            }
        }

        $this->offers = new \ArrayObject();

        if (isset($data['offer'])) {
            if (isset($data['offer'][0])) {
                foreach ($data['offer'] as $offer) {
                    $tmpObj = new OfferUpdate();
                    $tmpObj->denormalize($denormalizer, $offer, $format);
                    $this->offers[] = $tmpObj;
                }
            } elseif (!empty($data['offer'])) {
                $tmpObj = new OfferUpdate();
                $tmpObj->denormalize($denormalizer, $data['offer'], $format);
                $this->offers[] = $tmpObj;
            }
        }
    }

    /**
     * Return the batch id of offer update
     *
     * @return string
     */
    public function getBatchId()
    {
        return $this->batch_id;
    }

    /**
     * @return \ArrayObject|Error[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return \ArrayObject|OfferUpdate[]
     */
    public function getOffersUpdate()
    {
        return $this->offers;
    }
}
