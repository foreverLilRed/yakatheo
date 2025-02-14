<?php

namespace App\Imports;

use App\Models\Community;
use App\Models\Procurement;
use App\Models\Productor;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class UploadImport implements ToCollection, WithCalculatedFormulas
{
    public $socios, $fecha, $inicio, $fin;

    public function __construct($socios = 0, $fecha, $inicio, $fin)
    {
        $this->socios = $socios;
        $this->fecha = $fecha;
        $this->inicio = $inicio;
        $this->fin = $fin;
    }
    public function separarNombreApellido($nombres_completos)
    {
        $palabras = explode(" ", trim($nombres_completos));
        $total = count($palabras);

        if ($total == 1) {
            return [
                'nombres' => $nombres_completos,
                'apellidos' => ''
            ];
        }

        if ($total == 2) {
            return [
                'nombres' => $palabras[0],
                'apellidos' => $palabras[1]
            ];
        }

        $apellidos = implode(" ", array_slice($palabras, -2));
        $nombres = implode(" ", array_slice($palabras, 0, $total - 2));

        return [
            'nombres' => $nombres,
            'apellidos' => $apellidos
        ];
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $rows->skip($this->inicio)->take($this->fin)->each(function ($row) {
            $dni = !empty($row[1]) ? $row[1] : null;;
            //$nombres_completos = $this->separarNombreApellido($row[2]);
            $nombres = !empty($row[2]) ? $row[2] : null;
            //$apellidos = $nombres_completos['apellidos'] ?? 'Sin Apellidos';
            $nacimiento = !empty($row[5]) ? Date::excelToDateTimeObject($row[5])->format('Y-m-d') : null;
            $comunidadNombre = !empty($row[7]) ? $row[7] : null;

            $productor = null;

            $kg_values = [
                $row[8],
                $row[9],
                $row[10],
                $row[11],
                $row[12],
                $row[13]
            ];

            $total_values = [
                $row[15],
                $row[16],
                $row[17],
                $row[18],
                $row[19],
                $row[20]
            ];

            if ($comunidadNombre !== null) {
                $comunidad = Community::where('name', 'like', "%{$comunidadNombre}%")->first();

                if (!$comunidad) {
                    $comunidad = Community::create(['name' => $comunidadNombre]);
                }
            }

            $query = Productor::query();

            if ($dni !== null || $nombres !== null) {
                $query = Productor::query();
            
                if ($dni !== null) {
                    $query->where('dni', $dni);
                }
            
                if ($nombres !== null) {
                    $query->where('names', 'like', "%{$nombres}%");
                }
            
                $productor = $query->first();
            }

            $productor = $query->exists() ? $query->first() : null;

            if ($productor) {
                if (!$productor->community_id && $comunidad) {
                    $productor->community_id = $comunidad->id;
                    $productor->save();
                }
            } else {
                $productor = Productor::create([
                    "names" => $nombres ?? 'No identificado',
                    "surnames" => '',
                    "dni" => $dni,
                    "birthday" => $nacimiento,
                    "socio" => $this->socios,
                    "community_id" => $comunidad ? $comunidad->id : null
                ]);
            }


            if (
                array_filter($kg_values, fn($val) => $val !== null && $val != 0) &&
                array_filter($total_values, fn($val) => $val !== null && $val != 0)
            ) {



                $productos = [
                    1 => [8, 15],
                    2 => [9, 16],
                    3 => [10, 17],
                    4 => [11, 18],
                    5 => [12, 19],
                    6 => [13, 20]
                ];

                foreach ($productos as $product_id => [$kg_index, $total_index]) {
                    $kg = $row[$kg_index];
                    $total = $row[$total_index];

                    if (($kg !== null || $kg != 0) && ($total !== null || $total != 0)) {
                        $procurement = new Procurement();
                        $procurement->productor_id = $productor ? $productor->id : null;
                        $procurement->product_id = $product_id;
                        $procurement->weight = $kg;
                        $procurement->unit_price = $total / $kg;
                        $procurement->timestamps = false;
                        $procurement->created_at = Carbon::parse($this->fecha);
                        $procurement->updated_at = Carbon::parse($this->fecha);
                        $procurement->save();
                    }
                }
            }
        });
    }
}
