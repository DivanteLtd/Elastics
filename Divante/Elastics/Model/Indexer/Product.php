<?php
/**
 * Created by jcegielka@divante.pl
 */

namespace Divante\Elastics\Model\Indexer;

class Product implements \Magento\Indexer\Model\ActionInterface, \Magento\Framework\Mview\ActionInterface
{

    /**
     * @var Product\Action\Row
     */
    protected $_productFlatIndexerRow;

    /**
     * @param Product\Action\Row $productFlatIndexerRow
     */
    public function __construct(
        Product\Action\Row $productFlatIndexerRow
    ) {
        $this->_productFlatIndexerRow = $productFlatIndexerRow;
    }

    /**
     * Execute full indexatio
     *
     * @return void
     */
    public function executeFull()
    {
        $this->_productFlatIndexerRow->execute(1);


    }

    /**
     * Execute partial indexation by ID list
     *
     * @param int[] $ids
     *
     * @return void
     */
    public function executeList(array $ids)
    {
    }

    /**
     * Execute partial indexation by ID
     *
     * @param int $id
     *
     * @return void
     */
    public function executeRow($id)
    {
        $this->_productFlatIndexerRow->execute($id);
    }

    /**
     * Execute materialization on ids entities
     *
     * @param int[] $ids
     *
     * @return void
     */
    public function execute($ids)
    {
        $this->_productFlatIndexerRow->execute($ids);
    }
}