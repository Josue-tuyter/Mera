<?php

namespace App\Pdf;

use App\Models\User;

class UsuariosPdf extends BaseReportePdf
{
    public function __construct()
    {
        parent::__construct('Reporte de Usuarios');
    }

    protected function view(): string
    {
        return 'pdf.usuarios';
    }

    protected function data(): array
    {
        $usuarios = User::all()->map(function ($user) {
            $user->name = $this->utf8($user->name);
            $user->email = $this->utf8($user->email);
            return $user;
        });

        return [
            'usuarios' => $usuarios,
        ];
    }
}
