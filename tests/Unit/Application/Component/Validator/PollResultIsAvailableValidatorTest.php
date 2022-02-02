<?php

declare(strict_types=1);

namespace tests\Meals\Unit\Application\Component\Validator;

use Meals\Application\Component\Validator\Exception\PollResultIsNotAvailableException;
use Meals\Application\Component\Validator\PollResultIsAvailableValidator;
use PHPUnit\Framework\TestCase;
use tests\Meals\Constant\ValidatorConstant;

class PollResultIsAvailableValidatorTest extends TestCase
{
    public function testSuccessful()
    {
        $validator = new PollResultIsAvailableValidator();
        verify(
          $validator->validate(new \DateTime(ValidatorConstant::CORRECT_DATETIME, new \DateTimeZone(ValidatorConstant::TIMEZONE)))
        )->null();
    }

    public function testFailDay()
    {
        $this->expectException(PollResultIsNotAvailableException::class);

        $validator = new PollResultIsAvailableValidator();
        $validator->validate(new \DateTime(ValidatorConstant::WRONG_DAY, new \DateTimeZone(ValidatorConstant::TIMEZONE)));
    }

    public function testFailTime()
    {
        $this->expectException(PollResultIsNotAvailableException::class);

        $validator = new PollResultIsAvailableValidator();
        $validator->validate(new \DateTime(ValidatorConstant::WRONG_DATETIME, new \DateTimeZone(ValidatorConstant::TIMEZONE)));
    }
}
