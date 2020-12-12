<?php
/**
 * Support ProductTranscript Module
 *
 * @category  Support
 * @package   Support_ProductTranscript
 */
namespace Support\ProductTranscript\Ui\Component\Listing\Column;

class ProductTranscriptActions extends \Magento\Ui\Component\Listing\Columns\Column
{
    const URL_PATH_TRANSCRIPT = 'producttranscript/transcript/create';

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * AthletesAssign constructor.
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     * @param null $actions
     */
    public function __construct(
         \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
       $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

   /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['entity_id'])) {
                    $item[$this->getData('name')] = [
                        'transcript' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_TRANSCRIPT,
                                [
                                    'entity_id' => $item['entity_id']
                                ]
                            ),
                            'label' => __('Transcript')
                        ],
                    ];
                }
            }
        }
        
        return $dataSource;
    }
}
