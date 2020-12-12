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
use Magento\Catalog\Model\Product;
use Psr\Log\LoggerInterface;
use Support\ProductTranscript\Helper\Data;

/**
 * Class Create
 * @package Support\ProductTranscript\Controller\Adminhtml\Transcript
 */
class Create extends \Magento\Backend\App\Action
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
     * @var Filter
     */
    protected $filter;

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * Create constructor.
     * @param Context $context
     * @param LoggerInterface $logger
     * @param ScopeConfigInterface $scopeConfig
     * @param PageFactory $resultPageFactory
     * @param Product $product
     * @param Data $transcriptHelper
     * @param \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory
     */
    public function __construct(
        Context $context,
        LoggerInterface $logger,
        ScopeConfigInterface $scopeConfig,
        PageFactory $resultPageFactory,
        Product $product,
        Data $transcriptHelper,
        \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory
    )
    {
        $this->logger = $logger;
        $this->scopeConfig = $scopeConfig;
        $this->pageFactory = $resultPageFactory;
        $this->_product = $product;
        $this->transcriptHelper = $transcriptHelper;
        $this->resultRedirectFactory = $resultRedirectFactory;
        parent::__construct($context);
    }


    /**
     * Index Action*
     * @return $resultRedirect
     */
    public function execute()
    {
        try{
            $productId = $this->getRequest()->getParam('entity_id');
            $createProductNew = $this->transcriptHelper->createProductNew($productId);
            $createProductRefurnished = $this->transcriptHelper->createProductRefurbished($productId);
            if($createProductNew && $createProductRefurnished)
            {
                $this->addLogger("Support :: Createing The Both Products :");
                $this->messageManager->addSuccess(__('Created Products Successfully'));
            }else{
               $this->addLogger("Support :: Not Created The product");
               $this->messageManager->addNotice(__('Not Created the Product'));
            }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('producttranscript/transcript/index');
        }catch (\Throwable $e) {
            $errorMsg = "PRODUCT TRANSCRIPT SAVE TASK FAILED:\n MESSAGE: {$e->getMessage()} \n LINE NUMBER : {$e->getLine()}";
            $this->addLogger("Support :: Product Transcript Task Error :");
            $this->logger->critical("Support :: Product Transcript Task Error :" . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
        return $resultRedirect;
        
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

    /**
     * @param $log
     * @return mixed
     */
    protected function addLogger($log)
    {
        return $this->logger->addDebug("Support :: Product Transcript :: " . $log);
    }
}
