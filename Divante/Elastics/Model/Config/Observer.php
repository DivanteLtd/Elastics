<?php
/**
 * Created by jcegielka@divante.pl
 */

namespace Divante\Elastics\Model\Config;

class Observer
{
    /**
     * @var \Divante\Elastics\Helper\Data
     */
    private $helper;
    /**
     * @var \Divante\Elastics\Model\Indexer\Product\Elasticsearch
     */
    private $elasticsearch;
    /**
     * @var \Magento\Backend\App\Action\Context
     */
    private $context;

    /**
     * @param \Divante\Elastics\Helper\Data                         $helper
     * @param \Divante\Elastics\Model\Indexer\Product\Elasticsearch $elasticsearch
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Divante\Elastics\Helper\Data $helper,
        \Divante\Elastics\Model\Indexer\Product\Elasticsearch $elasticsearch
    ) {
        $this->helper = $helper;
        $this->elasticsearch = $elasticsearch;
        $this->context = $context;
    }

    public function afterConfigSectionSave(\Magento\Framework\Event\Observer $observer)
    {
        if(!$response = $this->helper->checkIfIndexExists()){
            $this->elasticsearch->createIndex();
            $this->context->getMessageManager()->addSuccess(__("Elasticsearch index created"));
        }
    }
}