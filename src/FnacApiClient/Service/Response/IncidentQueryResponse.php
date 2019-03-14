<?php
/*
 * This file is part of the fnacApi.
 * (c) 2011 Fnac
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FnacApiClient\Service\Response;

use FnacApiClient\Entity\Incident;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * IncidentQueryResponse service base definition for incident query response
 *
 * @author     Fnac
 * @version    1.0.0
 */
class IncidentQueryResponse extends ResponseService
{
    /** @var \ArrayObject|Incident[] */
    private $incidents;

    /**
     * {@inheritdoc}
     */
    public function denormalize(DenormalizerInterface $denormalizer, $data, $format = null, array $context = array())
    {
        parent::denormalize($denormalizer, $data, $format);

        $this->incidents = new \ArrayObject();
        if (isset($data['incident'])) {
            if (isset($data['incident'][0])) {
                foreach ($data['incident'] as $order_detail_incident) {
                    $tmpObj = new Incident();
                    $tmpObj->denormalize($denormalizer, $order_detail_incident, $format);
                    $this->incidents[] = $tmpObj;
                }
            } elseif (!empty($data['incident'])) {
                $tmpObj = new Incident();
                $tmpObj->denormalize($denormalizer, $data['incident'], $format);
                $this->incidents[] = $tmpObj;
            }
        }
    }

    /**
     * @return \ArrayObject|Incident[]
     */
    public function getIncidents()
    {
        return $this->incidents;
    }
}
