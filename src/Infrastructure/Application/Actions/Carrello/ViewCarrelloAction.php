<?php

declare(strict_types=1);

namespace App\Infrastructure\Application\Actions\Carrello;

use Psr\Http\Message\ResponseInterface as Response;

class ViewCarrelloAction extends CarrelloAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $carrelloId = (string) $this->resolveArg('id');
        $carrello = $this->carrelloRepository->findCarrelloById($carrelloId);

        $this->logger->info(sprintf('Carrello with id %s was viewed.', $carrelloId));

        return $this->respondWithData($carrello);
    }
}
