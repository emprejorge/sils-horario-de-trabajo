<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\HorarioModel;
use CodeIgniter\I18n\Time;

class Admin extends BaseController
{

    public function index()
    {
        $usuarioModel = new UserModel();
        $horarioModel = new HorarioModel();

        $data = [
            'totalUsuarios' => $usuarioModel->countAll(),
            'totalPendientes' => $horarioModel->where('approved', 0)->countAllResults(),
            'totalAprobados' => $horarioModel->where('approved', 1)->countAllResults(),
        ];

        return view('admin/dashboard', $data);
    }

    private function verificarAdmin()
    {
        if (!session()->get('user')['logged_in'] || session()->get('user')['role'] != 1) {
            return redirect()->to('/horario');
        }
    }

    public function usuarios()
    {
        if ($redirect = $this->verificarAdmin()) return $redirect;

        $userModel = new UserModel();

        $users = $userModel
            ->select('users.*, horarios.approved, horarios.approved_at')
            ->join('horarios', 'horarios.user_id = users.id', 'left')
            ->findAll();

        return view('admin/usuarios', [
            'users' => $users
        ]);
    }

    public function verHorario($userId)
    {
        if ($redirect = $this->verificarAdmin()) return $redirect;

        $horarioModel = new HorarioModel();
        $userModel = new UserModel();

        $usuario = $userModel->find($userId);

        $horario = $horarioModel
            ->where('user_id', $userId)
            ->first();

        if (!$horario) {
            $horarioModel->insert(['user_id' => $userId]);
            $horario = $horarioModel
                ->where('user_id', $userId)
                ->first();
        }

        return view('admin/ver_horario', [
            'usuario' => $usuario,
            'horario' => $horario
        ]);
    }

    public function guardarHorario($userId)
    {
        if ($redirect = $this->verificarAdmin()) return $redirect;

        $horarioModel = new HorarioModel();

        $horario = $horarioModel
            ->where('user_id', $userId)
            ->first();

        if ($horario) {
            $data = $this->request->getPost();

            // Manejo correcto del checkbox
            $approved = $this->request->getPost('approved') ? 1 : 0;

            // Obtener horario actual
            $horario = $horarioModel
                ->where('user_id', $userId)
                ->first();

            // Si pasa de NO aprobado → aprobado
            if (!$horario['approved'] && $approved == 1) {
                $data['approved_at'] = Time::now()->toDateTimeString();
            }

            // Si pasa de aprobado → no aprobado
            if ($horario['approved'] && $approved == 0) {
                $data['approved_at'] = null;
            }

            $data['approved'] = $approved;

            $horarioModel->update($horario['id'], $data);
        }

        return redirect()->to('/admin/horario/' . $userId)
            ->with('success', 'Horario actualizado');
    }


    public function imprimir($userId)
    {
        $horarioModel = new HorarioModel();

        $horario = $horarioModel
            ->where('user_id', $userId)
            ->first();

        return view('imprimir', [
            'horario' => $horario
        ]);
    }
}
