<?php

declare(strict_types=1);

namespace Apedik\PasswordAttributes\Block;

use Apedik\PasswordAttributes\Helper\PasswordRequirementType;
use Apedik\PasswordAttributes\Model\Config;
use Magento\Framework\View\Element\Block\ArgumentInterface;

readonly class PasswordAttributes implements ArgumentInterface
{
    public function __construct(
        private Config $config
    ) {
    }

    public function getPasswordPattern(): string
    {
        $requirementType = PasswordRequirementType::from($this->config->getPasswordCharacterClassesNumber());
        return $requirementType->getPattern($this->config->getPasswordMinimumLength());
    }

    public function getPasswordRules(): string
    {
        $requirements = array_map(
            static fn($type) => $type->getRequirementText(),
            array_slice(PasswordRequirementType::cases(), 0, $this->config->getPasswordCharacterClassesNumber())
        );

        return sprintf(
            "minlength: %s; %s",
            $this->config->getPasswordMinimumLength(),
            implode('; ', $requirements)
        );
    }
}
