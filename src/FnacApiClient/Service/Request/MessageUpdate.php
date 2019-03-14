<?php
/*
 * This file is part of the fnacMarketPlace APi Client.
 * (c) 2011 Fnac
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FnacApiClient\Service\Request;

use FnacApiClient\Entity\Message;
use FnacApiClient\Service\Response\MessageUpdateResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * MessageUpdate Service's definition.
 *
 * @author     Fnac
 * @version    1.0.0
 */

class MessageUpdate extends Authentified
{
    const ROOT_NAME = "messages_update";
    const XSD_FILE = "MessagesUpdateService.xsd";
    const CLASS_RESPONSE = MessageUpdateResponse::class;

    private $messages = [];

    /**
     * {@inheritdoc}
     */
    public function __construct(array $parameters = null)
    {
        parent::__construct($parameters);

        $this->messages = new \ArrayObject();
    }

    /**
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, $format = null, array $context = [])
    {
        $data = parent::normalize($normalizer, $format);

        $data['message'] = [];

        if ($this->messages->count() > 1) {
            foreach ($this->messages as $message) {
                $data['message'][] = $message->normalize($normalizer, $format);
            }
        } elseif ($this->messages->count()) {
            $data['message'] = $this->messages[0]->normalize($normalizer, $format);
        }

        return $data;
    }

    /**
     * Add message to update
     *
     * @param Message $message Message to update
     */
    public function addMessage(Message $message)
    {
        $this->messages[] = $message;
    }
}
