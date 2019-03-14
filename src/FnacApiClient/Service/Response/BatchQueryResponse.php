<?php
/*
 * This file is part of the fnacApi.
 * (c) 2011 Fnac
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FnacApiClient\Service\Response;

use FnacApiClient\Entity\Batch;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * BatchQueryResponse service base definition for batch query response
 *
 * @author     Fnac
 * @version    1.0.0
 */
class BatchQueryResponse extends ResponseService
{
    private $nb_batch_running;
    private $nb_batch_active;

    /** @var \ArrayObject|Batch[] */
    private $batchs = null;

    /**
     * {@inheritdoc}
     */
    public function denormalize(DenormalizerInterface $denormalizer, $data, $format = null, array $context = array())
    {
        parent::denormalize($denormalizer, $data, $format);

        $this->nb_batch_running = $data['nb_batch_running'];
        $this->nb_batch_active = $data['nb_batch_active'];

        $this->batchs = new \ArrayObject();

        if (isset($data['batch'])) {
            if (isset($data['batch'][0])) {
                foreach ($data['batch'] as $batch) {
                    $tmpObj = new Batch();
                    $tmpObj->denormalize($denormalizer, $batch, $format);
                    $this->batchs[] = $tmpObj;
                }
            } elseif (!empty($data['batch'])) {
                $tmpObj = new Batch();
                $tmpObj->denormalize($denormalizer, $data['batch'], $format);
                $this->batchs[] = $tmpObj;
            }
        }
    }

    /**
     * Number of imports being processed
     *
     * @return int
     */
    public function getNbBatchRunning()
    {
        return $this->nb_batch_running;
    }

    /**
     * Number of imports waiting to be processed
     *
     * @return int
     */
    public function getNbBatchActive()
    {
        return $this->nb_batch_active;
    }

    /**
     * @return \ArrayObject|Batch[]
     */
    public function getBatchs()
    {
        return $this->batchs;
    }
}
