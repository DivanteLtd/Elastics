<?php
/**
 * Created by jcegielka@divante.pl
 */

namespace Divante\Elastics\Model\Indexer\Product;

use \Magento\Catalog\Model\Product;

class Attributes
{
    /**
     * @var \Divante\Elastics\Helper\Data
     */
    protected $helper;
    /**
     * @var \Magento\Eav\Model\AttributeRepository
     */
    protected $attributeRepository;
    /**
     * @var \Magento\Framework\Api\SearchCriteriaDataBuilder
     */
    protected $searchCriteriaBuilder;
    /**
     * @var \Magento\Framework\Api\FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @param \Divante\Elastics\Helper\Data                    $helper
     * @param \Magento\Eav\Model\AttributeRepository           $attributeRepository
     * @param \Magento\Framework\Api\SearchCriteriaDataBuilder $searchCriteriaBuilder
     * @param \Magento\Framework\Api\FilterBuilder             $filterBuilder
     */
    public function __construct(
        \Divante\Elastics\Helper\Data $helper,
        \Magento\Eav\Model\AttributeRepository $attributeRepository,
        \Magento\Framework\Api\SearchCriteriaDataBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\FilterBuilder $filterBuilder
    ) {
        $this->helper = $helper;
        $this->attributeRepository = $attributeRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
    }

    public function getAttributeProperties($attributes)
    {
        $types = $properties = array();

        foreach ($attributes as $attribute) {
            $attributeModel = $this->attributeRepository->get(Product::ENTITY, $attribute);
            $types[$attribute] = array(
                "type" => $this->getElasticSearchType($attributeModel->getBackendType())
            );
        }

        $properties = array(
            '_source' => array(
                'enabled' => true
            ),
            "properties" => $types
        );

        return $properties;
    }

    /**
     * @param string $attributeBackendType
     *
     * @return string
     */
    private function getElasticSearchType($attributeBackendType)
    {
        switch($attributeBackendType){
            case "varchar":
                $type = "string";
                break;
            case "decimal":
                $type = "float";
                break;
            case "int":
                $type = "integer";
                break;
            case "datetime":
                $type = "date";
                break;
            default:
                $type = "string";
        }

        return $type;
    }
}