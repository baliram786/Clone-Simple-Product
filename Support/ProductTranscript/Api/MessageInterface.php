<?php
/**
 * Support ProductTranscript Module
 *
 * @category  Support
 * @package   Support_ProductTranscript
 */
namespace Support\ProductTranscript\Api;

/**
 * Interface MessageInterface
 * @api
 */
interface MessageInterface
{
    /**
     * @param string $message
     * @return void
     */
    public function setMessage($message);

    /**
     * @return string
     */
    public function getMessage();
}
