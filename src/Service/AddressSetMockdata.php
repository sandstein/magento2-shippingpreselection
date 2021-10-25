<?php

declare(strict_types=1);

// phpcs:disable Generic.Files.LineLength.TooLong

namespace IntegerNet\ShippingPreselection\Service;

use Magento\Customer\Api\Data\AddressInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Quote\Model\Quote\Address;

class AddressSetMockdata
{

    public const CONFIG_PATH_DEFAULT_COUNTRY_ID = 'general/country/default';
    public const CONFIG_PATH_DEFAULT_REGION_ID  = 'general/store_information/region_id';
    public const CONFIG_PATH_DEFAULT_POSTCODE   = 'general/store_information/postcode';
    public const CONFIG_PATH_MOCK_DATASET       = 'integernet/shipping_preselection/mock_data';

    private ScopeConfigInterface $storeConfig;

    public function __construct(ScopeConfigInterface $storeConfig)
    {
        $this->storeConfig = $storeConfig;
    }

    public function setMockDataOnAddress(Address $address): void
    {
        $prefill = $this->storeConfig->getValue(self::CONFIG_PATH_MOCK_DATASET, 'store');

        $address->setFirstname($address->getFirstname() ?: $prefill);
        $address->setLastname($address->getLastname() ?: $prefill);
        $address->setPostcode($address->getPostcode() ?: $this->storeConfig->getValue(self::CONFIG_PATH_DEFAULT_POSTCODE, 'store'));
        $address->setCity($address->getCity() ?: $prefill);
        $address->setTelephone($address->getTelephone() ?: $prefill);
        $address->setRegionId($address->getRegionId() ?: $this->storeConfig->getValue(self::CONFIG_PATH_DEFAULT_REGION_ID, 'store'));
        $address->setCountryId($address->getData('country_id') ?: $this->storeConfig->getValue(self::CONFIG_PATH_DEFAULT_COUNTRY_ID, 'store'));
        $address->setStreet((is_array($address->getStreet()) && count($address->getStreet()) && $address->getStreet()[0] !== '') || is_string($address->getStreet()) && strlen($address->getStreet()) ? $address->getStreet() : [$prefill]);
    }
}
