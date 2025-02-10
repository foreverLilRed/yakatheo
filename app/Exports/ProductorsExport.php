<?php

namespace App\Exports;

use App\Models\Productor;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductorsExport implements FromCollection
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

        if(!empty($this->filters['birthday'])){
            return $query->whereDate('birthday','>',$this->filters['birthday']);
        }

        if(!empty($this->filters['community'])){
            return $query->where('community_id', $this->filters['community']);
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

        return $query->get();
    }
}
