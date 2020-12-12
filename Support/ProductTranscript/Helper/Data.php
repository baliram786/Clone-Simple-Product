<?php
/**
 * Support ProductTranscript Module
 *
 * @category  Support
 * @package   Support_ProductTranscript
 */
namespace Support\ProductTranscript\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductFactory;
use Psr\Log\LoggerInterface;

/**
 * Class Data
 * @package Support\ProductTranscript\Helper
 */
class Data extends AbstractHelper
{

    const NEW_KEY = 'New';

    const USED_KEY = 'used';

    const REFURBISHED_KEY = 'refurbished';

    const USED_SKU = 'NEW';

    const NEW_REFURBISHED_KEY = 'REFURBISHED';

    const NEW_SKU = 'USED';

    const NEW_URL = 'new';

    const USED_URL = 'used';

    const NEW_TITLE = 'new';

    const USED_TITLE = 'used';


    /**
     * @var Context
     */
    protected $context;


    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Logger Interface
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Data constructor.
     * @param Context $context
     * @param ScopeConfigInterface $scopeConfig
     * @param Registry $registry
     * @param StoreManagerInterface $storeManagerInterface
     * @param Product $product
     * @param ProductFactory $productFactory
     * @param Product\Copier $productCopier
     * @param LoggerInterface $logger
     * @param \Magento\CatalogInventory\Model\Stock\StockItemRepository $stockItemRepository
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        Registry $registry,
        StoreManagerInterface $storeManagerInterface,
        Product $product,
        ProductFactory $productFactory,
        LoggerInterface $logger,
        \Magento\CatalogInventory\Model\Stock\StockItemRepository $stockItemRepository
    )
    {
        $this->context = $context;
        $this->scopeConfig = $scopeConfig;
        $this->registry = $registry;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->_product = $product;
        $this->_productFactory = $productFactory;
        $this->logger = $logger;
        $this->_stockItemRepository = $stockItemRepository;
        parent::__construct($context);
    }

    /**
     * @param $entityId
     * @return bool
     * @throws \Exception
     */
    public function createProductNew($entityId){

    try{
       $mainProduct = $this->_product->load($entityId);
       $mainProductName = $mainProduct->getName();
       $stockQuantity = $mainProduct->getQuantityAndStockStatus();
    if(strpos($mainProductName, self::NEW_KEY) !== false)
    {
        $this->addLogger("Support :: Product Transcript SKU of main:".$mainProduct->getSku());
        $mainProductName = $mainProduct->getName();
        $mainProductSku = $mainProduct->getSku();
        $mainProductUrl = $mainProduct->getProductUrl();
        $mainProductUrlKey = $mainProduct->getUrlKey();
        $mainProductMetaTitle = $mainProduct->getMetaTitle();
        $newProductName = str_replace(self::NEW_KEY, self::USED_KEY, $mainProductName);
        $newProductSku = str_replace(self::USED_SKU, self::NEW_SKU, $mainProductSku);
        $newProductMetaTitle = str_replace(self::NEW_TITLE, self::USED_TITLE, $mainProductSku);
        $newProductUrl = str_replace(self::NEW_URL, self::USED_URL, $mainProductUrl);
        $newProductUrlKey = str_replace(self::NEW_URL, self::USED_URL, $mainProductUrlKey);
        $newProduct = $this->_productFactory->create();
        $newProduct->setSku($newProductSku);
        $newProduct->setName($newProductName);
        // $newProduct->setProductUrl($newProductUrl);
        $newProduct->setUrlKey($newProductUrlKey);
        $newProduct->setAttributeSetId(4);
        $newProduct->setVisibility(4);
        $newProduct->setTaxClassId(0); 
        $newProduct->setTypeId('simple'); 
        $newProduct->setWebsiteIds(array(
            0
           ));
        $newProduct->setTitle($mainProductMetaTitle);
        $newProduct->setMetaTitle($mainProductMetaTitle);
        $newProduct->setPrice($mainProduct->getPrice());
        $newProduct->setStockData(array(
                'use_config_manage_stock' => 0,
                'manage_stock' => 1,
                'is_in_stock' => 1,
                'qty' => $stockQuantity['qty']
        ));
        $newProduct->save();
        $this->addLogger("Support :: Product Transcript Saved of New:".$newProduct->getSku());
        return true;
    }else{
        $this->addLogger("Support :: Product Transcript Not Saved:");
        return false;
    }
    }catch (\Throwable $e) {
        $errorMsg = "PRODUCT TRANSCRIPT NEW SAVE TASK FAILED:\n MESSAGE: {$e->getMessage()} \n LINE NUMBER : {$e->getLine()}";
        $this->addLogger("Support :: Product Transcript Task Error :");
        $this->logger->critical("Support :: Product Transcript Task Error :" . $e->getMessage());
        throw new \Exception($e->getMessage());
    }
    return false;
}

    /**
     * @param $entityId
     * @return bool
     * @throws \Exception
     */
    public function createProductRefurbished($entityId){

    try{
       $mainProductRefurbished = $this->_product->load($entityId);
       $mainProductName = $mainProductRefurbished->getName();
       $stockQuantityRefurbished = $mainProductRefurbished->getQuantityAndStockStatus();
    if(strpos($mainProductName, self::NEW_KEY) !== false)
    {
        $mainProductName = $mainProductRefurbished->getName();
        $mainProductSku = $mainProductRefurbished->getSku();
        $mainProductUrl = $mainProductRefurbished->getProductUrl();
        $mainProductUrlKey = $mainProductRefurbished->getUrlKey();
        $mainProductMetaTitle = $mainProductRefurbished->getMetaTitle();
        $newProductName = str_replace(self::NEW_KEY, self::REFURBISHED_KEY, $mainProductName);
        $newProductSku = str_replace(self::USED_SKU, self::NEW_REFURBISHED_KEY, $mainProductSku);
        $newProductMetaTitle = str_replace(self::NEW_TITLE, self::REFURBISHED_KEY, $mainProductSku);
        $newProductUrl = str_replace(self::NEW_URL, self::REFURBISHED_KEY, $mainProductUrl);
        $newProductUrlKey = str_replace(self::NEW_URL, self::REFURBISHED_KEY, $mainProductUrlKey);
        $newProductRefurbished = $this->_productFactory->create();
        $newProductRefurbished->setSku($newProductSku);
        $newProductRefurbished->setName($newProductName); 
        // $newProductRefurbished->setProductUrl($newProductUrl);
        $newProductRefurbished->setUrlKey($newProductUrlKey);
        $newProductRefurbished->setAttributeSetId(4);
        $newProductRefurbished->setVisibility(4);
        $newProductRefurbished->setTaxClassId(0); 
        $newProductRefurbished->setTypeId('simple'); 
        $newProductRefurbished->setWebsiteIds(array(
            0
           ));
        $newProductRefurbished->setTitle($mainProductMetaTitle);
        $newProductRefurbished->setPrice($mainProductRefurbished->getPrice());
        $newProductRefurbished->setStockData(array(
                'use_config_manage_stock' => 0,
                'manage_stock' => 1,
                'is_in_stock' => 1,
                'qty' => $stockQuantityRefurbished['qty']
        ));
        $newProductRefurbished->save();
        $this->addLogger("Support :: Product Transcript Saved of New:".$newProductRefurbished->getSku());
        return true;
    }else{
        $this->addLogger("Support :: Product Transcript Not Saved:");
        return false;
    }
    }catch (\Throwable $e) {
        $errorMsg = "PRODUCT TRANSCRIPT REFURBISHED SAVE TASK FAILED:\n MESSAGE: {$e->getMessage()} \n LINE NUMBER : {$e->getLine()}";
        $this->addLogger("Support :: Product Transcript Task Error :");
        $this->logger->critical("Support :: Product Transcript Task Error :" . $e->getMessage());
        throw new \Exception($e->getMessage());
    }
    return false;
}



   /**
     * @param $log
     * @return mixed
     */
    protected function addLogger($log)
    {
        return $this->logger->addDebug("Support :: Product Transcript  :: " . $log);
    }

}