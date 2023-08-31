<?php
declare(strict_types=1);

namespace Apedik\PasswordAttributes\Test\Unit\Block;

use Apedik\PasswordAttributes\Block\PasswordAttributes;
use Apedik\PasswordAttributes\Model\Config;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PasswordAttributesTest extends TestCase
{
    private const LENGTH_8_ONLY_DIGITS_PASSWORD = '12345678';
    private const LENGTH_4_ONLY_DIGITS_PASSWORD = '1234';
    private const UPPERCASE_DIGITS_PASSWORD = '12345678A';
    private const UPPERCASE_LOWERCASE_DIGITS_PASSWORD = '12345678Aa';
    private const UPPERCASE_LOWERCASE_DIGITS_SPECIAL_CHARS_PASSWORD = '12345678Aa-';
    private const PASSWORD_MIN_LENGTH = 8;

    private MockObject|Config $config;
    private PasswordAttributes $passwordAttrib;

    protected function setUp(): void
    {
        $this->config = $this->createMock(Config::class);
        $this->passwordAttrib = new PasswordAttributes($this->config);

        parent::setUp();
    }

    public function assertPasswordRules(int $requirements, string $passwordRules): void
    {
        $this->config->expects($this->once())->method('getPasswordCharacterClassesNumber')->willReturn($requirements);
        $this->config->expects($this->once())->method('getPasswordMinimumLength')->willReturn(
            self::PASSWORD_MIN_LENGTH,
        );
        $passwordPattern = $this->passwordAttrib->getPasswordRules();
        $this->assertSame(sprintf($passwordRules, self::PASSWORD_MIN_LENGTH), $passwordPattern);
    }

    public function getPasswordPattern(int $requirements): string
    {
        $this->config->expects($this->once())->method('getPasswordCharacterClassesNumber')->willReturn($requirements);
        $this->config->expects($this->once())->method('getPasswordMinimumLength')->willReturn(
            self::PASSWORD_MIN_LENGTH,
        );
        return $this->passwordAttrib->getPasswordPattern();
    }

    public function assertFailsPasswordRequirements(int $requirements, string $expectedPassword): void
    {
        $passwordPattern = $this->getPasswordPattern($requirements);
        $this->assertDoesNotMatchRegularExpression("/$passwordPattern/", $expectedPassword);
    }

    public function testGetPasswordPatternMatchesDigits(): void
    {
        $this->assertPasswordRequirements(
            PasswordAttributes::ONLY_DIGITS_REQUIREMENTS,
            self::LENGTH_8_ONLY_DIGITS_PASSWORD,
        );
    }

    public function assertPasswordRequirements(int $requirements, string $expectedPassword): void
    {
        $passwordPattern = $this->getPasswordPattern($requirements);
        $this->assertMatchesRegularExpression("/$passwordPattern/", $expectedPassword);
    }

    public function testGetPasswordPatternMatchesDigitsWhenLengthIsWrong(): void
    {
        $this->assertFailsPasswordRequirements(
            PasswordAttributes::ONLY_DIGITS_REQUIREMENTS,
            self::LENGTH_4_ONLY_DIGITS_PASSWORD,
        );
    }

    public function testGetPasswordPatternMatchesUppercase(): void
    {
        $this->assertPasswordRequirements(
            PasswordAttributes::UPPERCASE_DIGITS_REQUIREMENTS,
            self::UPPERCASE_DIGITS_PASSWORD,
        );
    }

    public function testGetPasswordPatternMatchesUppercaseFails(): void
    {
        $this->assertFailsPasswordRequirements(
            PasswordAttributes::UPPERCASE_DIGITS_REQUIREMENTS,
            self::LENGTH_8_ONLY_DIGITS_PASSWORD,
        );
    }

    public function testGetPasswordPatternMatchesUppercaseLowercase(): void
    {
        $this->assertPasswordRequirements(
            PasswordAttributes::LOWERCASE_UPPERCASE_DIGITS_REQUIREMENTS,
            self::UPPERCASE_LOWERCASE_DIGITS_PASSWORD,
        );
    }

    public function testGetPasswordPatternMatchesUppercaseLowercaseFails(): void
    {
        $this->assertFailsPasswordRequirements(
            PasswordAttributes::LOWERCASE_UPPERCASE_DIGITS_REQUIREMENTS,
            self::UPPERCASE_DIGITS_PASSWORD,
        );
    }

    public function testGetPasswordPatternMatchesUppercaseLowercaseSpecialChars(): void
    {
        $this->assertPasswordRequirements(
            PasswordAttributes::LOWERCASE_UPPERCASE_DIGITS_SPECIAL_CHARS_REQUIREMENTS,
            self::UPPERCASE_LOWERCASE_DIGITS_SPECIAL_CHARS_PASSWORD,
        );
    }

    public function testGetPasswordPatternMatchesUppercaseLowercaseSpecialCharsFails(): void
    {
        $this->assertFailsPasswordRequirements(
            PasswordAttributes::LOWERCASE_UPPERCASE_DIGITS_SPECIAL_CHARS_REQUIREMENTS,
            self::UPPERCASE_LOWERCASE_DIGITS_PASSWORD,
        );
    }


    public function testGetPasswordRulesOnlyDigits(): void
    {
        $this->assertPasswordRules(
            PasswordAttributes::ONLY_DIGITS_REQUIREMENTS,
            'minlength: %s; required: digit',
        );
    }

    public function testGetPasswordRulesDigitsUppercase(): void
    {
        $this->assertPasswordRules(
            PasswordAttributes::UPPERCASE_DIGITS_REQUIREMENTS,
            'minlength: %s; required: digit; required: upper',
        );

    }

    public function testGetPasswordRulesDigitsUppercaseLowercase(): void
    {
        $this->assertPasswordRules(
            PasswordAttributes::LOWERCASE_UPPERCASE_DIGITS_REQUIREMENTS,
            'minlength: %s; required: digit; required: upper; required: lower',
        );
    }

    public function testGetPasswordRulesDigitsUppercaseLowercaseSpecialChars(): void
    {
        $this->assertPasswordRules(
            PasswordAttributes::LOWERCASE_UPPERCASE_DIGITS_SPECIAL_CHARS_REQUIREMENTS,
            'minlength: %s; required: digit; required: upper; required: lower; required:  [-().&@?\'#,/&quot;+]',
        );
    }
}
