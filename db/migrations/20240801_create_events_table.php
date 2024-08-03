<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEventsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('events');
        $table->addColumn('title', 'string', ['limit' => 255])
              ->addColumn('description', 'text')
              ->addColumn('start_datetime', 'datetime')
              ->addColumn('end_datetime', 'datetime')
              ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
              ->addColumn('updated_at', 'datetime', ['null' => true, 'default' => null])
              ->create();
    }
}
