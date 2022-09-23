<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Createestoque extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'Id' => [
				'type' => 'int',
                'auto_increment' => true,
			],
			'Id_material' => [
				'type' => 'int'
			],
			'Id_ca' => [
				'type' => 'int',
			],
			'Quantidade' => [
				'type' => 'int'
			],
		]);
        $this->forge->addKey('Id', true);
		$this->forge->addForeignKey('Id_material', 'Materiais', 'Id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('Id_ca', 'CAs', 'Id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Estoque');
	}

	public function down()
	{
		$this->forge->dropTable('Estoque');
	}
}
