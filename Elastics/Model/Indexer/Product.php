<?php
/**
 * Created by jcegielka@divante.pl
 */

namespace Divante\Elastics\Model\Indexer;

class Product implements \Magento\Indexer\Model\ActionInterface, \Magento\Framework\Mview\ActionInterface
{

    /**
     * Execute full indexation
     *
     * @return void
     */
    public function executeFull()
    {
        // TODO: Implement executeFull() method.
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
        // TODO: Implement executeList() method.
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
        // TODO: Implement executeRow() method.
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
        // TODO: Implement execute() method.
}}