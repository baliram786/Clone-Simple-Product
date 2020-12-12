<?php
/**
 * Support ProductTranscript Module
 *
 * @category  Support
 * @package   Support_ProductTranscript
 */
namespace Support\ProductTranscript\Api;

use Support\ProductTranscript\Api\MessageInterface;

/**
 * Interface SubscriberInterface
 * @api
 */
interface SubscriberInterface
{
    /**
     * @return void
     */
    public function processMessage(MessageInterface $message);
}
