<?php
 
namespace Sanjay\Search\Observer;
 
use Magento\Framework\View\Page\Config;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Model\Category;
use Magento\Search\Model\QueryFactory;
use Netcore\Cee\Logger\Logger;

class Searchdispatch implements ObserverInterface
{

    /**
     * @var \Magento\Framework\View\LayoutInterface
     */
    protected $_layout;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    protected $_eventManager;

    protected $_queryFactory;

    protected $_request;

    protected $collection;
    private $logger;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\LayoutInterface $layout,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Search\Model\QueryFactory $queryFactory,
        Config $config,
        Logger $logger,
        \Magento\CatalogSearch\Model\ResourceModel\Fulltext\Collection $collection,
        \Netcore\Cee\Helper\Data $helper
    ) {
         
    
        $this->_layout       = $layout;
        $this->_storeManager = $storeManager;
        $this->_request      = $request;
        $this->_eventManager = $eventManager;
        $this->_queryFactory = $queryFactory;
        $this->config        = $config;
        $this->collection    = $collection;
        $this->helper        = $helper;
        $this->logger        = $logger;
    }//end __construct()


    public function execute(EventObserver $observer)
    {
        $str    = $search = $json = '';
        $search = $this->_request->getParam('q');
        print_r($search);
        
        $productIdList  = [];
        // $this->collection->load();
        // print_r(get_class_methods($this->_queryFactory));
        $query = $this->_queryFactory->get();
        // dd($query);
        // dd(get_class_methods($query));
        if (!$query->isQueryTextShort()) {
            // dd($query->isQueryTextShort());
            // dd($this->collection->addSearchFilter($query->getQueryText()));
            // print_r($collection_res);
        }
        // print_r("Search ");
        // dd($query);
        
         
        print_r(get_class_methods($this->collection));
        $moduleName     = $this->_request->getModuleName();
        $controllerName = $this->_request->getControllerName();
        $actionName     = $this->_request->getActionName();
        print_r(":: moduleName   -> "  .$moduleName . "-> ". $controllerName . "-> ".$actionName);
        print_r($this->collection->getSearch());
        $productdata  = $this->collection->addSearchFilter($search);
        // $productdata  = $this->collection->addSearchFilter($query->getQueryText());
        // print_r($productdata);
        // print(gettype($this->collection));
        // print(gettype($productdata));
        // print('Json');
        // // print_r(json_encode( $this->collection));
        // echo "exit";
       
        foreach ($productdata as $product) {
            $productIdList[] = $product->getId();
        }
        print_r($productIdList);
        
    }//end execute()
}//end class
