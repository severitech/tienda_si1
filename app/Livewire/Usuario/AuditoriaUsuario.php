<?php

namespace App\Livewire\Usuario;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AuditoriaUsuario extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $nombre_usuario = '';
    public $accion = '';
    public $ip = '';
    public $fecha_inicio;
    public $fecha_fin;
    public $orden_campo = 'created_at';
    public $orden_direccion = 'desc';

    protected $columnasOrdenables = [
        'created_at' => 'a.created_at',
        'accion' => 'a.accion',
        'direccion_ip' => 'a.direccion_ip',
        'usuario' => 'u.nombre',
    ];

    public function mount()
    {
        $this->fecha_inicio = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->fecha_fin = Carbon::now()->format('Y-m-d');
    }

    public function updated($property)
    {
        $this->resetPage();
    }

    public function ordenarPor($campo)
    {
        if ($this->orden_campo === $campo) {
            $this->orden_direccion = $this->orden_direccion === 'asc' ? 'desc' : 'asc';
        } else {
            $this->orden_campo = $campo;
            $this->orden_direccion = 'asc';
        }

        $this->resetPage();
    }

    public function limpiarFiltros()
    {
        $this->nombre_usuario = '';
        $this->accion = '';
        $this->ip = '';
        $this->fecha_inicio = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->fecha_fin = Carbon::now()->format('Y-m-d');
        $this->orden_campo = 'created_at';
        $this->orden_direccion = 'desc';

        $this->resetPage();
    }

    private function queryBase()
    {
        return DB::table('BITACORA as a')
            ->join('users as u', 'a.user_id', '=', 'u.id')
            ->select(
                'a.accion',
                'a.direccion_ip',
                'a.created_at',
                'u.nombre as usuario'
            )
            ->when($this->nombre_usuario, fn($q) =>
                $q->where('u.nombre', 'like', '%' . $this->nombre_usuario . '%')
            )
            ->when($this->accion, fn($q) =>
                $q->where('a.accion', 'like', '%' . $this->accion . '%')
            )
            ->when($this->ip, fn($q) =>
                $q->where('a.direccion_ip', 'like', '%' . $this->ip . '%')
            )
            ->when($this->fecha_inicio, fn($q) =>
                $q->whereDate('a.created_at', '>=', $this->fecha_inicio)
            )
            ->when($this->fecha_fin, fn($q) =>
                $q->whereDate('a.created_at', '<=', $this->fecha_fin)
            )
            ->orderBy($this->columnasOrdenables[$this->orden_campo] ?? 'a.created_at', $this->orden_direccion);
    }

    public function exportarPDF()
    {
        $auditorias = $this->queryBase()->get();

        $pdf = Pdf::loadView('reportes.auditoria-usuario-pdf', [
            'auditorias' => $auditorias,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
        ])->setPaper('a4', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'auditoria_usuarios_' . now()->format('Ymd_His') . '.pdf');
    }

    public function render()
    {
        $auditorias = $this->queryBase()->paginate($this->perPage);

        return view('livewire.usuario.auditoria-usuario', [
            'auditorias' => $auditorias,
        ]);
    }
}
