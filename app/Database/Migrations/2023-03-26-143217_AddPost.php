<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPost extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false
            ],
            'author' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'content' => [
                'type' => 'VARCHAR',
                'constraint' => '1000',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
            'created_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('post');
    }

    public function down()
    {
        $this->forge->dropTable('post');
    }
}
