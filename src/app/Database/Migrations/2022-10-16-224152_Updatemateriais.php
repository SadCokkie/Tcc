<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Updatemateriais extends Migration
{
	public function up()
	{
		$fields = [
			'IdGrupo' => ['type' => 'numeric'],
		];
		$this->forge->addColumn('Materiais', $fields);
		$this->forge->dropColumn('Materiais', 'Grupo');
	}

	public function down()
	{
		$fields = [
			'Grupo' => ['type' => 'varchar', 'constraint' => '40'],
		];
		$this->forge->addColumn('Materiais', $fields);
		$this->forge->dropColumn('Materiais', 'IdGrupo');
	}

}
