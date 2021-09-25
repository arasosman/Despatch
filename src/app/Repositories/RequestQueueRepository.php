<?php

namespace App\Repositories;

use App\Models\RequestQueue;
use App\Repositories\Contracts\RequestQueueRepositoryContract;

class RequestQueueRepository implements RequestQueueRepositoryContract
{
    public function create(array $data)
    {
        return RequestQueue::create($data);
    }

    public function findByType(string $type)
    {
        return RequestQueue::query()
            ->where('type', '=', $type)
            ->orderByDesc('id')
            ->first();
    }

    public function isEmpty(): bool
    {
        return !RequestQueue::query()
            ->exists();
    }
}
