<?php

namespace App\Models;

use CodeIgniter\Model;

class HorarioModel extends Model
{
    protected $table            = 'horarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [

        'user_id',
        'horas',
        'is_teacher',

        // Lunes
        'lun_entrada_manana',
        'lun_salida_manana',
        'lun_entrada_tarde',
        'lun_salida_tarde',

        // Martes
        'mar_entrada_manana',
        'mar_salida_manana',
        'mar_entrada_tarde',
        'mar_salida_tarde',

        // Miércoles
        'mie_entrada_manana',
        'mie_salida_manana',
        'mie_entrada_tarde',
        'mie_salida_tarde',

        // Jueves
        'jue_entrada_manana',
        'jue_salida_manana',
        'jue_entrada_tarde',
        'jue_salida_tarde',

        // Viernes
        'vie_entrada_manana',
        'vie_salida_manana',
        'vie_entrada_tarde',
        'vie_salida_tarde',

        'approved',
        'approved_at'
    ];
}
