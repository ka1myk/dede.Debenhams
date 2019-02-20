<?php

namespace Evincemage\Translate\Helper;


class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
		public function __construct(
    	\Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct($context);
    }
	public function getIsEnable()
	{
		return $this->scopeConfig->getValue('translate/active_display/enabled', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
		
	}

	public function getSniptcode()
	{
		return $this->scopeConfig->getValue('translate/active_display/translate_snippet', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
	
	}
}