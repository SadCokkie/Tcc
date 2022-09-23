<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Createmateriais extends Migration
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
			'Grupo' => [
				'type' => 'varchar',
				'constraint' => 40,
				'null' => true,
			],
			'Unidade_de_medida' => [
				'type' => 'varchar',
				'constraint' => 15,
			],
		]);
        $this->forge->addKey('Id', true);
        $this->forge->createTable('Materiais');
	}

	public function down()
	{
		$this->forge->dropTable('Materiais');
	}
}
