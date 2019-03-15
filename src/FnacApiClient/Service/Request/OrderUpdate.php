<?php
/*
 * This file is part of the fnacMarketPlace APi Client.
 * (c) 2011 Fnac
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FnacApiClient\Service\Request;

use FnacApiClient\Entity\Order;
use FnacApiClient\Service\Response\OrderUpdateResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * OrderUpdate Service's definition.
 *
 * @author     Fnac
 * @version    1.0.0
 */

class OrderUpdate extends Authentified
{
    const ROOT_NAME = "orders_update";
    const XSD_FILE = "OrdersUpdateService.xsd";
    const CLASS_RESPONSE = OrderUpdateResponse::class;

    /** @var \ArrayObject|Order[] */
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
     * Add order to update
     *
     * @param Order $order Order to update
     * @return void
     */
    public function addOrder(Order $order)
    {
        $this->orders[] = $order;
    }

    /**
     * @return \ArrayObject|Order[]
     */
    public function getOrders()
    {
        return $this->orders;
    }
}