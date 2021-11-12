<?php

declare(strict_types=1);

namespace App\Domain\Common\Model;

use App\Domain\Common\Traits\TimestampableModel;

abstract class DomainEntity implements \JsonSerializable
{
    use TimestampableModel;
}