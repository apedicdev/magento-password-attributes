<?php
declare(strict_types=1);

namespace Apedik\PasswordAttributes\Block;

use Apedik\PasswordAttributes\Model\Config;
use Magento\Framework\View\Element\Block\ArgumentInterface;

readonly class PasswordAttributes implements ArgumentInterface
{

    public const ONLY_DIGITS_REQUIREMENTS = 1;
    public const UPPERCASE_DIGITS_REQUIREMENTS = 2;
    public const LOWERCASE_UPPERCASE_DIGITS_REQUIREMENTS = 3;
    public const LOWERCASE_UPPERCASE_DIGITS_SPECIAL_CHARS_REQUIREMENTS = 4;
    private const ONLY_DIGITS_PATTERN = '^(?=.*\d).{%s,}$';
    private const UPPERCASE_DIGITS_PATTERN = '^(?=.*[A-Z])(?=.*\d).{%s,}$';
    private const UPPERCASE_LOWERCASE_DIGITS_PATTERN = '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{%s,}$';
    private const UPPERCASE_LOWERCASE_DIGITS_SPECIAL_CHARS_PATTERN = '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{%s,}$';

    private const REQUIREMENTS = [
        self::ONLY_DIGITS_REQUIREMENTS => 'required: digit',
        self::UPPERCASE_DIGITS_REQUIREMENTS => 'required: upper',
        self::LOWERCASE_UPPERCASE_DIGITS_REQUIREMENTS => 'required: lower',
        self::LOWERCASE_UPPERCASE_DIGITS_SPECIAL_CHARS_REQUIREMENTS => 'required:  [-().&@?\'#,/&quot;+]',
    ];

    public function __construct(private Config $config)
    {
    }

    public function getPasswordPattern(): string
    {
        $requiredNumber = $this->config->getPasswordCharacterClassesNumber();
        $minLength = $this->config->getPasswordMinimumLength();
        return match ($requiredNumber) {
            self::ONLY_DIGITS_REQUIREMENTS => sprintf(
                self::ONLY_DIGITS_PATTERN,
                $minLength,
            ),
            self::UPPERCASE_DIGITS_REQUIREMENTS => sprintf(
                self::UPPERCASE_DIGITS_PATTERN,
                $minLength,
            ),
            self::LOWERCASE_UPPERCASE_DIGITS_REQUIREMENTS => sprintf(
                self::UPPERCASE_LOWERCASE_DIGITS_PATTERN,
                $minLength,
            ),
            self::LOWERCASE_UPPERCASE_DIGITS_SPECIAL_CHARS_REQUIREMENTS => sprintf(
                self::UPPERCASE_LOWERCASE_DIGITS_SPECIAL_CHARS_PATTERN,
                $minLength,
            ),
        };
    }

    public function getPasswordRules(): string
    {
        $passwordRules = implode(
            '; ',
            array_slice(self::REQUIREMENTS, 0, $this->config->getPasswordCharacterClassesNumber()),
        );

        return sprintf(
            "minlength: %s; %s",
            $this->config->getPasswordMinimumLength(),
            $passwordRules,
        );
    }
}
