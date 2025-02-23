<?php

namespace App\Exports;

use App\Models\Productor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Carbon;

class ProductorsExport implements FromCollection, WithHeadings
{
    public $filters;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Productor::query();

        if (!empty($this->filters['birthday'])) {
            $query->whereDate('birthday', '>', $this->filters['birthday']);
        }

        if (!empty($this->filters['community'])) {
            $query->where('community_id', $this->filters['community']);
        }

        if (!empty($this->filters['terrains'])) {
            $requiredTerrainCount = (int) $this->filters['terrains'];
            $query->whereHas('terrains', function ($q) use ($requiredTerrainCount) {
                $q->groupBy('productor_id')
                  ->havingRaw('COUNT(*) > ?', [$requiredTerrainCount]);
            });
        }

        if (!empty($this->filters['certifications'])) {
            $requiredCertificationsCount = (int) $this->filters['certifications'];
            $query->whereHas('certifications', function ($q) use ($requiredCertificationsCount) {
                $q->groupBy('productor_id')
                  ->havingRaw('COUNT(*) > ?', [$requiredCertificationsCount]);
            });
        }

        return $query->get()->map(function ($productor) {
            return [
                'id' => $productor->id,
                'nombres' => $productor->names ?? 'No disponible en el campo respectivo',
                'dni' => $productor->dni ?? 'No disponible en el campo respectivo',
                'fecha_nacimiento' => $productor->birthday ? Carbon::parse($productor->birthday)->format('d \d\e F, Y') : 'No disponible en el campo respectivo',
                'edad' => $productor->birthday ? Carbon::parse($productor->birthday)->age : 'No disponible en el campo respectivo',  // Edad calculada
                'tierras' => $productor->terrains->count() ?? 'No disponible en el campo respectivo',
                'comunidad' => $productor->community ? $productor->community->name : 'No disponible en el campo respectivo',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Identificador', 
            'Nombres', 
            'DNI', 
            'Fecha de Nacimiento', 
            'Edad',
            'Número de Tierras',
            'Comunidad'
        ];
    }
}
