<?php

declare(strict_types=1);

namespace tests\Meals\Constant;

final class ValidatorConstant
{
    public const TIMEZONE = 'Europe/Prague';

    public const WRONG_DATETIME = '2022-01-24T23:03';
    public const WRONG_DAY = '2022-01-25T15:03';

    public const CORRECT_DATETIME = '2022-01-24T15:03';
}
