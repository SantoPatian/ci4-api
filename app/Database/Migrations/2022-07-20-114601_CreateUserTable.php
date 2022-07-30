<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserTable extends Migration
{

    public function up()
    {
        //

        $this->forge->addField('id uuid DEFAULT uuid_generate_v4() PRIMARY KEY');
        $this->forge->addField('data jsonb');
        $this->forge->createTable('users');

//        $this->forge->addField('id VARCHAR(128) PRIMARY KEY');
//        $this->forge->addField('data JSON');
//        $this->forge->createTable('users');

        $this->db->query("CREATE EXTENSION IF NOT EXISTS btree_gin");
        $this->db->query("CREATE INDEX ON users USING gin (data, id)");

//        $this->forge->addField('id VARCHAR(128) PRIMARY KEY');
//        $this->forge->addField('name VARCHAR(255)');
//        $this->forge->addField('email VARCHAR(255)');
//        $this->forge->createTable('users');

//        $this->forge->addField('id BIGINT AUTO_INCREMENT PRIMARY KEY');
//        $this->forge->addField('name VARCHAR(255)');
//        $this->forge->addField('email VARCHAR(255)');
//        $this->forge->createTable('users');
    }

    public function down()
    {
        //

        $this->forge->dropTable('users', true);
    }
}
