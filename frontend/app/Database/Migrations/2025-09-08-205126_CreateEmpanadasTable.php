<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmpanadasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'type'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'filling'    => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'price'      => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'is_sold_out' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('empanadas');
    }

    public function down()
    {
        $this->forge->dropTable('empanadas');
    }
}
