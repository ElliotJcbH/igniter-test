<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLogsTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'message' => [
                'type' => 'VARCHAR',
                'constraint' => '100'
            ]
        ]);

        $isPrimary = true;
        $this->forge->addKey('id', $isPrimary);

        $ifNotExists = true;
        $this->forge->createTable('logs', $ifNotExists);
    }

    public function down()
    {
        $ifExists = true;
        $this->forge->dropTable('logs', $ifExists);
    }
}
