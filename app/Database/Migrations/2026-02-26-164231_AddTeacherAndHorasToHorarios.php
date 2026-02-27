<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTeacherAndHorasToHorariosSafe extends Migration
{
    public function up()
    {
        // 1️⃣ Agregar columnas (permitiendo null temporalmente)
        $this->forge->addColumn('horarios', [
            'is_teacher' => [
                'type'  => 'BOOLEAN',
                'null'  => true,
                'after' => 'user_id',
            ],
            'horas' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true, // temporal
                'after'      => 'is_teacher',
            ],
        ]);

        // 2️⃣ Rellenar registros antiguos
        $this->db->query("UPDATE horarios SET horas = 0 WHERE horas IS NULL");

        // 3️⃣ Convertir horas en obligatorio
        $this->forge->modifyColumn('horarios', [
            'horas' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('horarios', [
            'is_teacher',
            'horas',
        ]);
    }
}
