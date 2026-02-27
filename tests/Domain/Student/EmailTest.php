<?php

declare(strict_types=1);

namespace Tests\Domain\Student;

use PHPUnit\Framework\TestCase;
use App\Domain\Student\Email;
use App\Domain\Shared\DomainException;

final class EmailTest extends TestCase
{
    public function test_valid_email_can_be_created(): void
    {
        $email = new Email('alumne@escola.cat');
        $this->assertInstanceOf(Email::class, $email);
        $this->assertSame('alumne@escola.cat', $email->value());
    }

    public function test_invalid_email_throws_exception(): void
    {
        $this->expectException(DomainException::class);
        new Email('alumne.escola.cat');
    }

    public function test_two_emails_with_same_values_are_equal(): void
    {
        $a = new Email('test@test.com');
        $b = new Email('test@test.com');
        $this->assertSame($a->value(), $b->value());
    }

    public function test_email_with_plus_addressing_is_valid(): void
    {
        $email = new Email('user+tag@example.com');
        $this->assertSame('user+tag@example.com', $email->value());
    }

    public function test_empty_email_throws_exception(): void
    {
        $this->expectException(DomainException::class);
        new Email('');
    }

    public function test_email_with_whitespace_throws_exception(): void
    {
        $this->expectException(DomainException::class);
        new Email('  user@example.com  ');
    }

    public function test_uppercase_email_is_allowed_and_preserved(): void
    {
        $email = new Email('USER@EXAMPLE.COM');
        $this->assertSame('USER@EXAMPLE.COM', $email->value());
    }

    public function test_very_long_email_throws_exception(): void
    {
        $local = str_repeat('a', 300);
        $long = sprintf('%s@example.com', $local);

        $this->expectException(DomainException::class);
        new Email($long);
    }
}