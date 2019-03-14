<?php
/*
 * This file is part of the fnacMarketPlace APi Client.
 * (c) 2011 Fnac
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FnacApiClient\Service\Request;

use FnacApiClient\Entity\IncidentOrder;
use FnacApiClient\Service\Response\IncidentUpdateResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * OfferUpdate Service's definition.
 *
 * @author     Fnac
 * @version    1.0.0
 */

class IncidentUpdate extends Authentified
{
    const ROOT_NAME = "incidents_update";
    const XSD_FILE = "IncidentsUpdateService.xsd";
    const CLASS_RESPONSE = IncidentUpdateResponse::class;

    /** @var \ArrayObject|IncidentOrder[] */
    private $orders = [];

    /**
     * {@inheritdoc}
     */
    public function __construct(array $parameters = null)
    {
        parent::__construct($parameters);

        $this->orders = new \ArrayObject();
    }

    /**
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, $format = null, array $context = [])
    {
        $data = parent::normalize($normalizer, $format);

        $data['order'] = [];

        if ($this->orders->count() > 1) {
            foreach ($this->orders as $order) {
                $data['order'][] = $order->normalize($normalizer, $format);
            }
        } elseif ($this->orders->count()) {
            $data['order'] = $this->orders[0]->normalize($normalizer, $format);
        }

        return $data;
    }

    /**
     * Add order incident to service
     *
     * @param IncidentOrder $order Incident Order to update
     */
    public function addOrder(IncidentOrder $order)
    {
        $this->orders[] = $order;
    }

    /**
     * @param \ArrayObject|IncidentOrder[] $orders
     */
    public function addOrders($orders)
    {
        foreach ($orders as $order) {
            $this->addOrder($order);
        }
    }
}
