<?php
/**
 * Created by jcegielka@divante.pl
 */

namespace Divante\Elastics\Model\Config\Source;


class Auth implements \Magento\Framework\Option\ArrayInterface
{

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => "no",
                'label' => "No Authorization"
            ),
            array(
                "value" => "basic",
                "label" => "HTTP Basic Auth"
            )
        );
    }
}