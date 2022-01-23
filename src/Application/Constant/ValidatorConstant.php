<?php

declare(strict_types=1);

namespace Meals\Application\Constant;

final class ValidatorConstant
{
    public const AVAILABLE_POLL_DAY = 'Monday'; // доступный день голосования
    public const POLL_START_TIME = '06:00'; // старт доступа к голосованию
    public const POLL_END_TIME = '22:00'; // окончание голосования
}
