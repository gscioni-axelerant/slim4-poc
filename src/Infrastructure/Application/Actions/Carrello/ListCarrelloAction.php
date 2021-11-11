<?php

declare(strict_types=1);

namespace App\Infrastructure\Application\Actions\Carrello;

use Psr\Http\Message\ResponseInterface as Response;

class ListCarrelloAction extends CarrelloAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $carrelli = $this->carrelloRepository->findAll();

        $this->logger->info('Carrelli list has been requested');

        return $this->respondWithData($carrelli);
    }
}
