<?php
/**
 * Created by jcegielka@divante.pl
 */

namespace Divante\Elastics\Model\Indexer\Product;

class Elasticsearch
{
    const TYPE_NAME = "product";

    /**
     * @var \Divante\Elastics\Helper\Data|Data
     */
    private $helper;

    /**
     * @param \Divante\Elastics\Helper\Data $helper
     */
    public function __construct(
        \Divante\Elastics\Helper\Data $helper
    )
    {
        $this->helper =  $helper;
    }

    /**
     * @param array $data
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
    }
}