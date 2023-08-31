<?php
declare(strict_types=1);

namespace Apedik\PasswordAttributes\Model;

use Magento\Customer\Model\AccountManagement;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class Config implements ArgumentInterface
{
    /**
     * Configuration path to enable password attributes
     */
    public const XML_PATH_PASSWORD_ATTRIBUTES_ENABLED = 'customer/password/form_password_attributes_enabled';

    /**
     * Configuration path to add regex password attributes pattern
     */
    public const XML_PATH_PASSWORD_ATTRIBUTES_PATTERN = 'customer/password/form_password_attributes_pattern_enabled';

    /**
     * Configuration path to add password rules
     */
    public const XML_PATH_PASSWORD_RULES_ENABLED = 'customer/password/form_password_attributes_rules_enabled';

    /**
     * Configuration path to customer password required character classes number
     */
    public const XML_PATH_REQUIRED_CHARACTER_CLASSES_NUMBER = 'customer/password/required_character_classes_number';


    public function __construct(private readonly ScopeConfigInterface $scopeConfig)
    {
    }

    public function isPasswordAttributesEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_PASSWORD_ATTRIBUTES_ENABLED);
    }

    public function isPasswordAttributesPattenEnabled(): bool
    {
        return $this->isPasswordAttributesEnabled() && $this->scopeConfig->isSetFlag(
                self::XML_PATH_PASSWORD_ATTRIBUTES_PATTERN,
            );
    }

    public function isPasswordRulesEnabled(): bool
    {
        return $this->isPasswordAttributesEnabled() && $this->scopeConfig->isSetFlag(
                self::XML_PATH_PASSWORD_RULES_ENABLED,
            );
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
