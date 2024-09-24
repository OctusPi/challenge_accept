<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateClientTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('clients');
        $table->addColumn('name', 'string', ['limit' => 255])
              ->addColumn('cpf', 'string', ['limit' => 12])
              ->addColumn('email', 'string', ['limit' => 255])
              ->addColumn('password', 'string', ['limit' => 255])
              ->addColumn('type', 'integer')
              ->addColumn('actions', 'text', ['null'=> true])
              ->addColumn('created_at', 'datetime')
              ->addColumn('updated_at', 'datetime')
              ->create();
    }
}
