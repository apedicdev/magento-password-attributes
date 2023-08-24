<?php
declare(strict_types=1);

namespace Apedik\PasswordAttributes\Block;

use Apedik\PasswordAttributes\Model\Config;
use Magento\Framework\View\Element\Block\ArgumentInterface;

readonly class PasswordAttributes implements ArgumentInterface
{

    public function __construct(private Config $config)
    {
    }

    public function getPasswordPattern(): string
    {
        $requiredNumber = $this->config->getPasswordCharacterClassesNumber();
        $minLength = $this->config->getPasswordMinimumLength();

        return match ($requiredNumber) {
            1 => sprintf('^(?=.*\d)[\d]{%s,}$', $minLength),
            2 => sprintf('^(?=.*[A-Z])(?=.*\d)[A-Z\d]{%s,}$', $minLength),
            3 => sprintf('^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{%s,}$', $minLength),
            4 => sprintf('^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{%s,}$', $minLength),
        };
    }
}
