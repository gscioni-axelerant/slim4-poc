<?php

declare(strict_types=1);

namespace App\Domain\Carrello\Exception;

use App\Domain\Common\DomainException\DomainErrorPersistingException;

class CarrelloIsEmptyException extends DomainErrorPersistingException
{
    public $message = 'Il carrello non può essere salvato perchè vuoto.';
}
