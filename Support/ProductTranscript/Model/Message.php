<?php
/**
 * Support ProductTranscript Module
 *
 * @category  Support
 * @package   Support_ProductTranscript
 */
namespace Support\ProductTranscript\Model;

use Support\ProductTranscript\Api\MessageInterface;

/**
 * Class Message
 * @package Support\ProductTranscript\Model
 */
class Message
{
      /**
     * @var string
     */
    protected $message;

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * {@inheritdoc}
     */
    public function setMessage($message)
    {
        return $this->message = $message;
    }
}