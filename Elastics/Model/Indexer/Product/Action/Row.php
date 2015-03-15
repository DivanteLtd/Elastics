<?php
/**
 * Created by jcegielka@divante.pl
 */

namespace Divante\Elastics\Model\Indexer\Product\Action;

class Row
{
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var \Divante\Elastics\Model\Indexer\Product\Elasticsearch
     */
    protected $elasticSearchModel;

    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Divante\Elastics\Model\Indexer\Product\Elasticsearch $elasticsearch
    )
    {
        $this->productRepository = $productRepository;
        $this->elasticSearchModel = $elasticsearch;
    }

    public function execute($id = null)
    {
        if (!isset($id) || empty($id)) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('Could not rebuild index for undefined product')
            );
        }

        try {
            $product = $this->productRepository->getById($id, false, 1);
        } catch (NoSuchEntityException $e) {
            return false;
        }

        $attrubutesArray = array(
            "name"        => $product->getName(),
            "sku"         => $product->getSku(),
            "description" => $product->getDescription(),
            "price"       => $product->getPrice(),
            "update_date" => $product->getUpdatedAt()
        );

        $this->elasticSearchModel->bulk($attrubutesArray);
    }
}