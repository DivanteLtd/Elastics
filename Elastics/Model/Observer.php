<?php
/**
 * Created by jcegielka@divante.pl
 */

namespace Divante\Elastics\Model;

class Observer
{
    /**
     * @var Indexer\Product\Action\Row
     */
    protected $_productFlatIndexerRow;

    /**
     * @param Indexer\Product\Action\Row $productFlatIndexerRow
     */
    public function __construct(
        Indexer\Product\Action\Row $productFlatIndexerRow
    ) {
        $this->_productFlatIndexerRow = $productFlatIndexerRow;
    }

    public function afterSaveProduct(\Magento\Framework\Event\Observer $observer)
    {
        $id = $observer->getEvent()->getController()->getRequest()->getParam("id");
        $this->_productFlatIndexerRow->execute($id);
    }
}