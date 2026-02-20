<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddApprovedAtToHorarios extends Migration
{
    public function up()
    {
        $this->forge->addColumn('horarios', [
            'approved_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'approved'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('horarios', 'approved_at');
    }
}
