<?php
/**
 * Created by jcegielka@divante.pl
 */

namespace Divante\Elastics\Model\Config\Source;

use \Magento\Catalog\Model\Product;

class Attributes implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \Magento\Eav\Model\AttributeRepository
     */
    private $attributeRepository;
    /**
     * @var \Magento\Framework\Api\SearchCriteriaDataBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var \Magento\Framework\Api\FilterBuilder
     */
    private $filterBuilder;

    /**
     * @param \Magento\Eav\Model\AttributeRepository           $attributeRepository
     * @param \Magento\Framework\Api\SearchCriteriaDataBuilder $searchCriteriaBuilder
     * @param \Magento\Framework\Api\FilterBuilder             $filterBuilder
     */
    public function __construct(
        \Magento\Eav\Model\AttributeRepository $attributeRepository,
        \Magento\Framework\Api\SearchCriteriaDataBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\FilterBuilder $filterBuilder
    ) {
        $this->attributeRepository = $attributeRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
    }

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        $optionArray = array();

        $this->searchCriteriaBuilder->addFilter(
            [$this->filterBuilder->setField('is_searchable')->setValue(1)->create()]
        );

        $attributes = $this->attributeRepository->getList(Product::ENTITY, $this->searchCriteriaBuilder->create());

        foreach ($attributes->getItems() as $attribute) {
            $optionArray[] = array(
                "value" => $attribute->getAttributeCode(),
                "label" => $attribute->getDefaultFrontendLabel()
            );
        }

        return $optionArray;
    }
}