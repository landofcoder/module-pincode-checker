<?php
/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Lof
 * @package   Lof\PincodeChecker
 * @author    Landofcoder <landofcoder@gmail.com>
 * @copyright 2020 Landofcoder
 * @license   https://landofcoder.com/LICENSE-1.0.html
 */
namespace Lof\PincodeChecker\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Lof\PincodeChecker\Helper\Data
     */
    protected $helper;

     /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Lof\PincodeChecker\Helper\Data $helper
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Lof\PincodeChecker\Helper\Data $helper,
        \Magento\Framework\Controller\Result\JsonFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->helper = $helper;
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if($this->getRequest()->isAjax()){

            $pincode = $this->getRequest()->getParam('p', false);
            $id = $this->getRequest()->getParam('id', false);
            $pincodeStatus = $this->helper->getPincodeStatus($pincode);
            $productStatus = $this->helper->getProductPincodeStatus($id, $pincode);

            if($productStatus){
                $message = $this->helper->getMessage(false, $pincode);
            }else{
                $message = $this->helper->getMessage($pincodeStatus, $pincode);
            }
    
            $resultJson = $this->resultPageFactory->create();
            
            return $resultJson->setData($message);
        }

        return false;
    }
}