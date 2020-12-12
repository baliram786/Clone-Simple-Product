<?php
/**
 * Support ProductTranscript Module
 *
 * @category  Support
 * @package   Support_ProductTranscript
 */
namespace Support\ProductTranscript\Controller\Adminhtml\Transcript;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Psr\Log\LoggerInterface;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Logger Interface
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * Index constructor.
     * @param LoggerInterface $logger
     * @param ScopeConfigInterface $scopeConfig
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        LoggerInterface $logger,
        ScopeConfigInterface $scopeConfig,
        Context $context,
        PageFactory $resultPageFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->logger = $logger;
        $this->_scopeConfig = $scopeConfig;
        parent::__construct($context);
    }


    /**
     * Index Action*
     * @return $resultPage
     */
    public function execute()
    {
        /** @var \MAgento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Transcript Products'));
        return $resultPage;
    }

    /**
     * Check Form List Permission.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Support_ProductTranscript::product_transcript');
    }
}
