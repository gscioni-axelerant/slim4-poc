<?php

declare(strict_types=1);

namespace App\Domain\Prodotto\Exception;

use App\Domain\Common\DomainException\DomainRecordNotFoundException;

class ProdottoNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'Il prodotto che hai richiesto non esiste.';
}
