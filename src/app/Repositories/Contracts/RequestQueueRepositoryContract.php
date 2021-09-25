<?php

namespace App\Repositories\Contracts;

interface RequestQueueRepositoryContract
{
    public function create(array $data);

    public function findByType(string $type);

    public function isEmpty(): bool;
}
