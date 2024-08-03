<?php

namespace App\Models;

use App\Models\EventDao;
use App\DTO\EventDTO;

class Event
{
    private $id;
    private $title;
    private $description;
    private $start_datetime;
    private $end_datetime;
    private $created_at;
    private $updated_at;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getStartDatetime()
    {
        return $this->start_datetime;
    }

    public function setStartDatetime($start_datetime)
    {
        $this->start_datetime = $start_datetime;
    }

    public function getEndDatetime()
    {
        return $this->end_datetime;
    }

    public function setEndDatetime($end_datetime)
    {
        $this->end_datetime = $end_datetime;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    public function getAll()
    {
        $eventDao = new EventDao();
        return $eventDao->list();
    }

    public function getAllFormatted()
    {
        $events = $this->getAll();
        $formattedEvents = [];

        foreach ($events as $event) {
            $formattedEvents[] = EventDTO::fromEvent($event);
        }

        return $formattedEvents;
    }
}
