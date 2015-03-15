<?php
/**
 * Created by jcegielka@divante.pl
 */

namespace Divante\Elastics\Model\Indexer\Product\Action;

use \Magento\Framework\Exception\NoSuchEntityException;

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
    /**
     * @var \Divante\Elastics\Helper\Data
     */
    protected $helper;

    /**
     * @param \Magento\Catalog\Api\ProductRepositoryInterface       $productRepository
     * @param \Divante\Elastics\Model\Indexer\Product\Elasticsearch $elasticsearch
     * @param \Divante\Elastics\Helper\Data                         $helper
     */
    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Divante\Elastics\Model\Indexer\Product\Elasticsearch $elasticsearch,
        \Divante\Elastics\Helper\Data $helper
    ) {
        $this->productRepository = $productRepository;
        $this->elasticSearchModel = $elasticsearch;
        $this->helper = $helper;
    }

    /**
     * @param null $id
     *
     * @return array|bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute($id = null)
    {
        if (!isset($id) || empty($id)) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('Could not rebuild index for undefined product'
            ));
        }

        try {
            $product = $this->productRepository->getById($id, false, 1);
        } catch (NoSuchEntityException $e) {
            return false;
        }

        $attributesArray = array();
        $attributes = $this->helper->getElasticSearchAttributesArray();

        foreach ($attributes as $attribute) {
            $attributesArray[$attribute] = $product->getData($attribute);
        }

        $attributesArray["update_date"] = $product->getUpdatedAt();
        $attributesArray["id"] = $product->getId();

        return $this->elasticSearchModel->bulk($attributesArray);
    }
}