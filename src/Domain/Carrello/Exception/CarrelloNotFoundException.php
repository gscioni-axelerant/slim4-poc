<?php

declare(strict_types=1);

namespace App\Domain\Carrello\Exception;

use App\Domain\Common\DomainException\DomainRecordNotFoundException;

class CarrelloNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'Il carrello che hai richiesto non esiste.';
}
