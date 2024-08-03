<?php

namespace App\DTO;

class EventDTO
{
    public $id;
    public $title;
    public $description;
    public $start;
    public $end;

    public function __construct($id, $title, $description, $start, $end)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->start = $start;
        $this->end = $end;
    }

    public static function fromEvent($event)
    {
        return new self(
            $event['id'],
            $event['title'],
            $event['description'],
            $event['start_datetime'],
            $event['end_datetime']
        );
    }
}
