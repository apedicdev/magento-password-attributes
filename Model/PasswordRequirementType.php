<?php

declare(strict_types=1);

namespace Apedik\PasswordAttributes\Helper;

enum PasswordRequirementType: int
{
    case ONLY_DIGITS = 1;
    case UPPERCASE_DIGITS = 2;
    case LOWERCASE_UPPERCASE_DIGITS = 3;
    case LOWERCASE_UPPERCASE_DIGITS_SPECIAL_CHARS = 4;

    public function getPattern(int $minLength): string
    {
        return match ($this) {
            self::ONLY_DIGITS => sprintf('^(?=.*\d).{%s,}$', $minLength),
            self::UPPERCASE_DIGITS => sprintf('^(?=.*[A-Z])(?=.*\d).{%s,}$', $minLength),
            self::LOWERCASE_UPPERCASE_DIGITS => sprintf('^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{%s,}$', $minLength),
            self::LOWERCASE_UPPERCASE_DIGITS_SPECIAL_CHARS => sprintf(
                '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{%s,}$',
                $minLength
            ),
        };
    }

    public function getRequirementText(): string
    {
        return match ($this) {
            self::ONLY_DIGITS => 'required: digit',
            self::UPPERCASE_DIGITS => 'required: upper',
            self::LOWERCASE_UPPERCASE_DIGITS => 'required: lower',
            self::LOWERCASE_UPPERCASE_DIGITS_SPECIAL_CHARS => 'required: [-().&@?\'#,/&quot;+]',
        };
    }
}
