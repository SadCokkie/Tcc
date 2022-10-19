<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Creategruposmateriais extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'Id' => [
				'type' => 'int',
                'auto_increment' => true,
			],
			'Nome' => [
				'type' => 'varchar',
				'constraint' => '40'
			],
		]);
        $this->forge->addKey('Id', true);
        $this->forge->createTable('GruposMateriais');
	}

	public function down()
	{
		$this->forge->dropTable('GruposMateriais');
	}
}
