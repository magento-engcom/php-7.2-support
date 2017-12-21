<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Tax\Model\System\Config\Source\Tax;

class Country extends \Magento\Directory\Model\Config\Source\Country
{
    /**
     * @var array
     */
    protected $_options;

    /**
     * @param bool $noEmpty
     * @return array
     */
    public function toOptionArray()
    {
        $args = func_get_args();
        $isMultiselect = isset($args[0]) ? $args[0] : false;
        $options = parent::toOptionArray($isMultiselect);

        if (!$isMultiselect) {
            if ($options) {
                $options[0]['label'] = __('None');
            } else {
                $options = [['value' => '', 'label' => __('None')]];
            }
        }

        return $options;
    }
}
