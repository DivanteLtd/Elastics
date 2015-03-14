<?php
/**
 * Created by jcegielka@divante.pl
 */

namespace Divante\Elastics\Helper;

use Elasticsearch\Client as Client;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const ELASTICSEARCH_URI_CONFIG_PATH = "elastics/configuration/elasticsearch_server_uri";

    /**
     * @param null $store
     *
     * @return Client
     */
    public function getElasticSearchConnection($store = null)
    {
        $essUri = $this->scopeConfig->getValue(
            self::ELASTICSEARCH_URI_CONFIG_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store
        );
        $params = array(
            "hosts" => array(
                $essUri
            )
        );

        $client = new Client($params);

        return $client;
    }
}