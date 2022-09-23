<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Createusuarios extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'Id' => [
				'type' => 'int',
                'auto_increment' => true,
			],
			'Usuario' => [
				'type' => 'char',
				'constraint' => 10,
			],
			'Senha' => [
				'type' => 'varchar',
				'constraint' => 40,
				'null' => true,
			],
			'Admin' => [
				'type' => 'int',
				'null' => true,
			],
		]);
        $this->forge->addKey('Id', true);
        $this->forge->createTable('Usuarios');
	}

	public function down()
	{
		$this->forge->dropTable('Usuarios');
	}
}
