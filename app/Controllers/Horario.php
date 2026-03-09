<?php

namespace App\Controllers;

use App\Models\HorarioModel;

class Horario extends BaseController
{
    public function index()
    {
        if (!session()->get('user')['logged_in']) {
            return redirect()->to('/');
        }
        $user = session()->get('user');

        $horarioModel = new HorarioModel();

        $userId = $user['id'];

        // Buscar horario del usuario
        $horario = $horarioModel
            ->where('user_id', $userId)
            ->first();

        // Si no existe, crearlo vacío
        if (!$horario) {
            $horarioModel->insert([
                'user_id' => $userId
            ]);

            $horario = $horarioModel
                ->where('user_id', $userId)
                ->first();
        }

        if (session()->get('user')['role'] == 1) {
            return view('horario/admin', [
                'horario' => $horario
            ]);
        } else {
            return view('horario/index', [
                'horario' => $horario
            ]);
        }
    }

    public function save()
    {
        if (!session()->get('user')['logged_in']) {
            return redirect()->to('/');
        }

        $user = session()->get('user');

        $horarioModel = new HorarioModel();

        $userId = $user['id'];

        $horario = $horarioModel
            ->where('user_id', $userId)
            ->first();

        if ($horario['approved'] == 1) {
            return redirect()->back()
                ->with('error', 'El horario ya fue aprobado y no puede modificarse.');
        }



        if ($horario) {

            $data = $this->request->getPost();

            // Manejo correcto del checkbox
            $is_teacher = $this->request->getPost('is_teacher') ? 1 : 0;




            // Nunca permitimos que el usuario apruebe su propio horario
            unset($data['approved']);
            $data['is_teacher'] = $is_teacher;

            $horarioModel->update($horario['id'], $data);
        }



        return redirect()->to('/horario')
            ->with('success', 'Horario guardado correctamente');
    }

    public function imprimir()
    {
        $user = session()->get('user');
        $horarioModel = new HorarioModel();
        $userId = $user['id'];

        $horario = $horarioModel
            ->where('user_id', $userId)
            ->first();

        return view('imprimir', [
            'horario' => $horario
        ]);
    }
}
