<?php
/*
 * This file is part of the fnacMarketPlace APi Client.
 * (c) 2011 Fnac
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FnacApiClient\Service\Request;

use FnacApiClient\Service\Response\CarrierQueryResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * CarrierQuery Service's definition.
 *
 * @author     Fnac
 * @version    1.0.0
 */
class CarrierQuery extends Authentified
{
    const ROOT_NAME = "carriers_query";
    const XSD_FILE = "CarriersQueryService.xsd";
    const CLASS_RESPONSE = CarrierQueryResponse::class;

    /**
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, $format = null, array $context = [])
    {
        return array_merge(parent::normalize($normalizer, $format), [
            'query' => 'all'
        ]);
    }
}
