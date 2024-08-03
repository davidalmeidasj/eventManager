<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventDao;

class EventServiceImpl implements EventService
{
    private $eventDao;

    public function __construct(EventDao $eventDao)
    {
        $this->eventDao = $eventDao;
    }

    public function createEvent(Event $event): bool
    {
        return $this->eventDao->create($event);
    }

    public function updateEvent(Event $event): bool
    {
        return $this->eventDao->update($event);
    }

    public function deleteEvent(int $id): bool
    {
        return $this->eventDao->delete($id);
    }

    public function getEvent(int $id): ?Event
    {
        return $this->eventDao->read($id);
    }

    public function getAllEvents(): array
    {
        // Assuming you have a method to fetch all events formatted
        return (new Event())->getAllFormatted();
    }
}
