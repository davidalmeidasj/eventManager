<?php

use PHPUnit\Framework\TestCase;
use Mockery as m;
use App\Services\EventServiceImpl;
use App\Models\EventDao;
use App\Models\Event;

class EventServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }

    public function testCreateEventSuccess()
    {
        $eventDao = m::mock(EventDao::class);
        $eventService = new EventServiceImpl($eventDao);

        $event = new Event();
        $event->setTitle('Sample Event');
        $event->setDescription('Event Description');
        $event->setStartDatetime('2024-08-03 10:00:00');
        $event->setEndDatetime('2024-08-03 12:00:00');

        $eventDao->shouldReceive('create')
            ->once()
            ->with(m::type(Event::class))
            ->andReturn(true);

        $result = $eventService->createEvent($event);

        $this->assertTrue($result);
    }

    public function testUpdateEventSuccess()
    {
        $eventDao = m::mock(EventDao::class);
        $eventService = new EventServiceImpl($eventDao);

        $event = new Event();
        $event->setId(1);
        $event->setTitle('Updated Event');
        $event->setDescription('Updated Description');
        $event->setStartDatetime('2024-08-03 10:00:00');
        $event->setEndDatetime('2024-08-03 12:00:00');

        $eventDao->shouldReceive('update')
            ->once()
            ->with(m::type(Event::class))
            ->andReturn(true);

        $result = $eventService->updateEvent($event);

        $this->assertTrue($result);
    }
}
