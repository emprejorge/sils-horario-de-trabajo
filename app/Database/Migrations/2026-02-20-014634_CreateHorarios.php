<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHorarios extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],

            // ======================
            // LUNES
            // ======================
            'lun_entrada_manana' => ['type'=>'TIME','null'=>true],
            'lun_salida_manana'  => ['type'=>'TIME','null'=>true],
            'lun_entrada_tarde'  => ['type'=>'TIME','null'=>true],
            'lun_salida_tarde'   => ['type'=>'TIME','null'=>true],

            // ======================
            // MARTES
            // ======================
            'mar_entrada_manana' => ['type'=>'TIME','null'=>true],
            'mar_salida_manana'  => ['type'=>'TIME','null'=>true],
            'mar_entrada_tarde'  => ['type'=>'TIME','null'=>true],
            'mar_salida_tarde'   => ['type'=>'TIME','null'=>true],

            // ======================
            // MIÉRCOLES
            // ======================
            'mie_entrada_manana' => ['type'=>'TIME','null'=>true],
            'mie_salida_manana'  => ['type'=>'TIME','null'=>true],
            'mie_entrada_tarde'  => ['type'=>'TIME','null'=>true],
            'mie_salida_tarde'   => ['type'=>'TIME','null'=>true],

            // ======================
            // JUEVES
            // ======================
            'jue_entrada_manana' => ['type'=>'TIME','null'=>true],
            'jue_salida_manana'  => ['type'=>'TIME','null'=>true],
            'jue_entrada_tarde'  => ['type'=>'TIME','null'=>true],
            'jue_salida_tarde'   => ['type'=>'TIME','null'=>true],

            // ======================
            // VIERNES
            // ======================
            'vie_entrada_manana' => ['type'=>'TIME','null'=>true],
            'vie_salida_manana'  => ['type'=>'TIME','null'=>true],
            'vie_entrada_tarde'  => ['type'=>'TIME','null'=>true],
            'vie_salida_tarde'   => ['type'=>'TIME','null'=>true],

            // ======================
            // APROBACIÓN
            // ======================
            'approved' => [
                'type' => 'BOOLEAN',
                'default' => false
            ],

            'created_at DATETIME default current_timestamp'
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey(
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('horarios');
    }

    public function down()
    {
        $this->forge->dropTable('horarios');
    }
}