<?php

namespace App\Services;

use App\Models\Event;

interface EventService
{
    public function createEvent(Event $event): bool;
    public function updateEvent(Event $event): bool;
    public function deleteEvent(int $id): bool;
    public function getEvent(int $id): ?Event;
    public function getAllEvents(): array;
}
