<?php

use PHPUnit\Framework\TestCase;
use Mockery as m;
use App\Controllers\EventController;
use App\Services\EventService;
use App\Validators\EventValidator;
use App\Models\Event;

class EventControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }

    private function captureOutput(callable $function)
    {
        try {
            $function();
        } catch (\App\Helpers\ResponseException $e) {
            return json_decode($e->getMessage(), true);
        }
        return null;
    }

    public function testCreateEventSuccess()
    {
        $eventService = m::mock(EventService::class);
        $eventValidator = m::mock(EventValidator::class);
        $controller = new EventController($eventService, $eventValidator);

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'title' => 'Sample Event',
            'description' => 'Event Description',
            'start_datetime' => '2024-08-05T10:00',
            'end_datetime' => '2024-08-06T12:00',
        ];

        $eventValidator->shouldReceive('validate')
            ->once()
            ->with($_POST)
            ->andReturn([]);

        $eventService->shouldReceive('createEvent')
            ->once()
            ->with(m::type(Event::class))
            ->andReturn(true);

        $response = $this->captureOutput(function() use ($controller) {
            $controller->create();
        });

        $this->assertArrayHasKey('success', $response);
        $this->assertTrue($response['success']);
        $this->assertArrayHasKey('message', $response);
        $this->assertEquals('Evento criado com sucesso', $response['message']);
    }

    public function testCreateEventValidationError()
    {
        $eventService = m::mock(EventService::class);
        $eventValidator = m::mock(EventValidator::class);
        $controller = new EventController($eventService, $eventValidator);

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'title' => '',
            'description' => '',
            'start_datetime' => '',
            'end_datetime' => '',
        ];

        $eventValidator->shouldReceive('validate')
            ->once()
            ->with($_POST)
            ->andReturn([
                'title' => 'O título é obrigatório',
                'description' => 'A descrição é obrigatória',
                'start_datetime' => 'A data e hora de início são obrigatórias',
                'end_datetime' => 'A data e hora de término são obrigatórias',
            ]);

        $response = $this->captureOutput(function() use ($controller) {
            $controller->create();
        });

        $this->assertArrayHasKey('success', $response);
        $this->assertFalse($response['success']);
        $this->assertArrayHasKey('message', $response);
        $this->assertEquals('Erro na validação', $response['message']);
        $this->assertArrayHasKey('errors', $response);
        $this->assertArrayHasKey('title', $response['errors']);
        $this->assertEquals('O título é obrigatório', $response['errors']['title']);
    }

    public function testEditEventSuccess()
    {
        $eventService = m::mock(EventService::class);
        $eventValidator = m::mock(EventValidator::class);
        $controller = new EventController($eventService, $eventValidator);

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'id' => 1,
            'title' => 'Updated Event',
            'description' => 'Updated Description',
            'start_datetime' => '2024-08-05T10:00',
            'end_datetime' => '2024-08-06T12:00',
        ];

        $eventValidator->shouldReceive('validate')
            ->once()
            ->with($_POST)
            ->andReturn([]);

        $eventService->shouldReceive('updateEvent')
            ->once()
            ->with(m::type(Event::class))
            ->andReturn(true);

        $response = $this->captureOutput(function() use ($controller) {
            $controller->edit();
        });

        $this->assertArrayHasKey('success', $response);
        $this->assertTrue($response['success']);
        $this->assertArrayHasKey('message', $response);
        $this->assertEquals('Evento atualizado com sucesso', $response['message']);
    }

    public function testEditEventValidationError()
    {
        $eventService = m::mock(EventService::class);
        $eventValidator = m::mock(EventValidator::class);
        $controller = new EventController($eventService, $eventValidator);

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'id' => 1,
            'title' => '',
            'description' => '',
            'start_datetime' => '',
            'end_datetime' => '',
        ];

        $eventValidator->shouldReceive('validate')
            ->once()
            ->with($_POST)
            ->andReturn([
                'title' => 'O título é obrigatório',
                'description' => 'A descrição é obrigatória',
                'start_datetime' => 'A data e hora de início são obrigatórias',
                'end_datetime' => 'A data e hora de término são obrigatórias',
            ]);

        $response = $this->captureOutput(function() use ($controller) {
            $controller->edit();
        });

        $this->assertArrayHasKey('success', $response);
        $this->assertFalse($response['success']);
        $this->assertArrayHasKey('message', $response);
        $this->assertEquals('Erro na validação', $response['message']);
        $this->assertArrayHasKey('errors', $response);
        $this->assertArrayHasKey('title', $response['errors']);
        $this->assertEquals('O título é obrigatório', $response['errors']['title']);
    }

    public function testCancelEventSuccess()
    {
        $eventService = m::mock(EventService::class);
        $controller = new EventController($eventService, new EventValidator());

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = ['id' => 1];

        $eventService->shouldReceive('deleteEvent')
            ->once()
            ->with(1)
            ->andReturn(true);

        $response = $this->captureOutput(function() use ($controller) {
            $controller->cancel();
        });

        $this->assertArrayHasKey('success', $response);
        $this->assertTrue($response['success']);
        $this->assertArrayHasKey('message', $response);
        $this->assertEquals('Evento cancelado com sucesso', $response['message']);
    }

    public function testGetListFormattedSuccess()
    {
        $eventService = m::mock(EventService::class);
        $controller = new EventController($eventService, new EventValidator());

        $events = [
            ['id' => 1, 'title' => 'Sample Event', 'description' => 'Event Description', 'start_datetime' => '2024-08-05T10:00', 'end_datetime' => '2024-08-06T12:00'],
        ];

        $eventService->shouldReceive('getAllEvents')
            ->once()
            ->andReturn($events);

        $response = $this->captureOutput(function() use ($controller) {
            $controller->getListFormatted();
        });

        $this->assertArrayHasKey('success', $response);
        $this->assertTrue($response['success']);
        $this->assertArrayHasKey('data', $response);
        $this->assertCount(1, $response['data']);
        $this->assertEquals($events, $response['data']);
    }

    public function testGetEventSuccess()
    {
        $eventService = m::mock(EventService::class);
        $controller = new EventController($eventService, new EventValidator());

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_GET = ['id' => 1];

        $event = new Event();
        $event->setId(1);
        $event->setTitle('Sample Event');
        $event->setDescription('Event Description');
        $event->setStartDatetime('2024-08-05T10:00');
        $event->setEndDatetime('2024-08-06T12:00');

        $eventService->shouldReceive('getEvent')
            ->once()
            ->with(1)
            ->andReturn($event);

        $response = $this->captureOutput(function() use ($controller) {
            $controller->getEvent();
        });

        $this->assertArrayHasKey('success', $response);
        $this->assertTrue($response['success']);
        $this->assertArrayHasKey('data', $response);
        $this->assertArrayHasKey('id', $response['data']);
        $this->assertEquals(1, $response['data']['id']);
    }

    public function testGetEventNotFound()
    {
        $eventService = m::mock(EventService::class);
        $controller = new EventController($eventService, new EventValidator());

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_GET = ['id' => 1];

        $eventService->shouldReceive('getEvent')
            ->once()
            ->with(1)
            ->andReturn(null);

        $response = $this->captureOutput(function() use ($controller) {
            $controller->getEvent();
        });

        $this->assertArrayHasKey('success', $response);
        $this->assertFalse($response['success']);
        $this->assertArrayHasKey('message', $response);
        $this->assertEquals('Evento não encontrado', $response['message']);
    }
}
