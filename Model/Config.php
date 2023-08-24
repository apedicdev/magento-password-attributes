<?php
declare(strict_types=1);

namespace Apedik\PasswordAttributes\Model;

use Magento\Customer\Model\AccountManagement;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

readonly class Config implements ArgumentInterface
{
    public const XML_PATH_PASSWORD_ATTRIBUTES_ENABLED = 'customer/password/form_password_attributes_enabled';
    public const XML_PATH_PASSWORD_ATTRIBUTES_PATTERN = 'customer/password/form_password_attributes_pattern_enabled';

    /**
     * Configuration path to customer password required character classes number
     */
    public const XML_PATH_REQUIRED_CHARACTER_CLASSES_NUMBER = 'customer/password/required_character_classes_number';


    public function __construct(private ScopeConfigInterface $scopeConfig)
    {
    }

    public function isPasswordAttributesEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_PASSWORD_ATTRIBUTES_ENABLED);
    }

    public function isPasswordAttributesPattenEnabled(): bool
    {
        return $this->isPasswordAttributesEnabled() && $this->scopeConfig->isSetFlag(self::XML_PATH_PASSWORD_ATTRIBUTES_PATTERN);
    }

    public function getPasswordCharacterClassesNumber(): int
    {
        return (int)$this->scopeConfig->getValue(self::XML_PATH_REQUIRED_CHARACTER_CLASSES_NUMBER);
    }

    public function getPasswordMinimumLength(): int
    {
        return (int)$this->scopeConfig->getValue(AccountManagement::XML_PATH_MINIMUM_PASSWORD_LENGTH);
    }

}
