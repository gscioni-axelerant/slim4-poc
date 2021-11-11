<?php

declare(strict_types=1);

namespace App\Infrastructure\Application\Actions\Carrello;

use App\Domain\Carrello\Model\CarrelloRepository;
use App\Infrastructure\Application\Actions\Action;
use Psr\Log\LoggerInterface;

abstract class CarrelloAction extends Action
{
    public function __construct(
        LoggerInterface $logger,
        protected CarrelloRepository $carrelloRepository
    ) {
        parent::__construct($logger);
    }
}
