<?php
/**
 * Support ProductTranscript Module
 *
 * @category  Support
 * @package   Support_ProductTranscript
 */
namespace Support\ProductTranscript\Model\Object\Source;


/**
 * Class ProductTranscriptConfig
 * @package Support\ProductTranscript\Model\Object\Source
 */
class ProductTranscriptConfig extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * @return array|array[]
     */
    public function getAllOptions()
    {
        return[
            ['value'=>'','label'=>__()],
            ['value'=>'used','label'=>__('Used')],
            ['value'=>'refurbished','label'=>__('Refurbished')]
        ];
    }

}