<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Createmovimentacoes extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'Id' => [
				'type' => 'int',
                'auto_increment' => true,
			],
			'Id_estoque' => [
				'type' => 'int'
			],
			'Quantidade' => [
				'type' => 'int',
			],
			'Entrada' => [
				'type' => 'int'
			],
		]);
        $this->forge->addKey('Id', true);
		$this->forge->addForeignKey('Id_estoque', 'Estoque', 'Id', 'CASCADE', 'CASCADE');
		$this->forge->createTable('Movimentacoes');
	}

	public function down()
	{
		$this->forge->dropTable('Movimentacoes');
	}
}
