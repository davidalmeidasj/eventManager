<?php

use PHPUnit\Framework\TestCase;
use App\Validators\EventValidator;

class EventValidatorTest extends TestCase
{
    public function testValidateSuccess()
    {
        $validator = new EventValidator();

        $now = new \DateTime("now", new \DateTimeZone('America/Sao_Paulo'));
        $startDatetime = $now->add(new \DateInterval('P1D'))->format('Y-m-d\TH:i');
        $endDatetime = $now->add(new \DateInterval('P1D'))->format('Y-m-d\TH:i');

        $data = [
            'title' => 'Sample Event',
            'description' => 'Event Description',
            'start_datetime' => $startDatetime,
            'end_datetime' => $endDatetime,
        ];

        $errors = $validator->validate($data);

        $this->assertEmpty($errors);
    }

    public function testValidateErrors()
    {
        $validator = new EventValidator();

        $data = [
            'title' => '',
            'description' => '',
            'start_datetime' => '',
            'end_datetime' => '',
        ];

        $errors = $validator->validate($data);

        $this->assertNotEmpty($errors);
        $this->assertArrayHasKey('title', $errors);
        $this->assertArrayHasKey('description', $errors);
        $this->assertArrayHasKey('start_datetime', $errors);
        $this->assertArrayHasKey('end_datetime', $errors);
    }

    public function testValidateInvalidStartDatetimeFormat()
    {
        $validator = new EventValidator();

        $data = [
            'title' => 'Sample Event',
            'description' => 'Event Description',
            'start_datetime' => 'invalid format',
            'end_datetime' => '2024-08-03T12:00',
        ];

        $errors = $validator->validate($data);

        $this->assertArrayHasKey('start_datetime', $errors);
        $this->assertEquals('Formato de data e hora de início inválido', $errors['start_datetime']);
    }

    public function testValidateStartDatetimeInPast()
    {
        $validator = new EventValidator();

        $data = [
            'title' => 'Sample Event',
            'description' => 'Event Description',
            'start_datetime' => '2023-01-01T10:00',
            'end_datetime' => '2024-08-03T12:00',
        ];

        $errors = $validator->validate($data);

        $this->assertArrayHasKey('start_datetime', $errors);
        $this->assertEquals('A data e hora de início não podem ser no passado', $errors['start_datetime']);
    }

    public function testValidateEndDatetimeBeforeStartDatetime()
    {
        $validator = new EventValidator();

        $data = [
            'title' => 'Sample Event',
            'description' => 'Event Description',
            'start_datetime' => '2024-08-03T12:00',
            'end_datetime' => '2024-08-03T10:00',
        ];

        $errors = $validator->validate($data);

        $this->assertArrayHasKey('end_datetime', $errors);
        $this->assertEquals('A data e hora de término não podem ser antes ou igual à data e hora de início', $errors['end_datetime']);
    }
}
