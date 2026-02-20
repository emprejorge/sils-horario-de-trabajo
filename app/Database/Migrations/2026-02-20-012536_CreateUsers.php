<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
        ],
        'google_id' => [
            'type' => 'VARCHAR',
            'constraint' => 255,
        ],
        'first_name' => [
            'type' => 'VARCHAR',
            'constraint' => 100,
        ],
        'last_name' => [
            'type' => 'VARCHAR',
            'constraint' => 150,
        ],
        'email' => [
            'type' => 'VARCHAR',
            'constraint' => 255,
            'unique' => true,
        ],
        'avatar' => [
            'type' => 'TEXT',
            'null' => true
        ],
        'role' => [
            'type' => 'INT',
            'constraint' => 1,
            'default' => 2
        ],
        'created_at DATETIME default current_timestamp'
    ]);

    $this->forge->addKey('id', true);
    $this->forge->createTable('users');
}

    public function down()
    {
        $this->forge->dropTable('users');
    }
}