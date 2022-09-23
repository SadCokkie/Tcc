<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Createcas extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'Id' => [
				'type' => 'int',
                'auto_increment' => true,
			],
			'Descricao' => [
				'type' => 'varchar',
				'constraint' => 40,
			],
		]);
        $this->forge->addKey('Id', true);
        $this->forge->createTable('CAs');
	}

	public function down()
	{
		$this->forge->dropTable('CAs');
	}
}
