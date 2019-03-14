<?php
/*
 * This file is part of the fnacApi.
 * (c) 2011 Fnac
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FnacApiClient\Service\Response;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * QueryResponse service base definition for query response
 *
 * @author     Fnac
 * @version    1.0.0
 */
abstract class QueryResponse extends ResponseService
{
    /** @var int */
    private $page;

    /** @var int */
    private $total_paging;

    /** @var int */
    private $nb_total_per_page;

    /** @var int */
    private $nb_total_result;

    /**
     * {@inheritdoc}
     */
    public function denormalize(DenormalizerInterface $denormalizer, $data, $format = null, array $context = array())
    {
        parent::denormalize($denormalizer, $data);

        $this->page = isset($data['page']) ? $data['page'] : 0;
        $this->total_paging = isset($data['total_paging']) ? $data['total_paging'] : 0;
        $this->nb_total_per_page = isset($data['nb_total_per_page']) ? $data['nb_total_per_page'] : 0;
        $this->nb_total_result = isset($data['nb_total_result']) ? $data['nb_total_result'] : 0;
    }

    /**
     * Page number
     *
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Number of page available
     *
     * @return int
     */
    public function getTotalPaging()
    {
        return $this->total_paging;
    }

    /**
     * Number of result per page
     *
     * @return int
     */
    public function getNbTotalPerPage()
    {
        return $this->nb_total_per_page;
    }

    /**
     * Number of result
     *
     * @return int
     */
    public function getNbTotalResult()
    {
        return $this->nb_total_result;
    }

    /**
     * Is the query have other result to be fetched ?
     *
     * @return bool
     */
    public function hasNextPage()
    {
        return (boolean) ($this->page < $this->total_paging);
    }
}
