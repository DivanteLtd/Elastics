<?php
/**
 * Created by jcegielka@divante.pl
 */

namespace Divante\Elastics\Model\Indexer\Product;

class Elasticsearch
{
    const TYPE_NAME = "product";

    /**
     * @var \Divante\Elastics\Helper\Data $helper
     */
    private $helper;
    /**
     * @var Attributes
     */
    private $attributes;

    /**
     * @param \Divante\Elastics\Helper\Data $helper
     * @param Attributes                    $attributes
     */
    public function __construct(
        \Divante\Elastics\Helper\Data $helper,
        \Divante\Elastics\Model\Indexer\Product\Attributes $attributes
    )
    {
        $this->helper =  $helper;
        $this->attributes = $attributes;
    }

    /**
     * @param $data
     *
     * @return array
     */
    public function bulk($data){
        $client = $this->helper->getElasticSearchConnection();
        $params = array();
        $params['index'] = $this->helper->getElasticSearchIndexName();
        $params['type'] = self::TYPE_NAME;
        $params['body'][] = array(
            'index' => array(
                '_id' => $data["id"]
            )
        );
        $params['body'][] = $data;

        $response = $client->bulk($params);

        return $response;
    }

    /**
     * @return array
     */
    public function createIndex(){
        $mappings = $this->getMappings();
        $params['body']['mappings'][self::TYPE_NAME] = $mappings;
        $params['index'] = $this->helper->getElasticSearchIndexName();
        $client = $this->helper->getElasticSearchConnection();
        return $client->indices()->create($params);
    }

    /**
     * @return array
     */
    private function getMappings()
    {
        $mappings = $this->attributes->getAttributeProperties($this->helper->getElasticSearchAttributesArray());
        return $mappings;
    }
}