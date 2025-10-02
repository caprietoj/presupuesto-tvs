<?php

namespace App\Imports;

use App\Models\Movimiento;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MovimientosImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        // Skip the first row (headers)
        $rows = $collection->skip(1);

        foreach ($rows as $row) {
            // Map columns by position (0-indexed)
            Movimiento::create([
                'fuente' => $row[0] ?? null,
                'documento' => $row[1] ?? null,
                'fecha' => $row[2] ?? null,
                'cuenta' => $row[3] ?? null,
                'descripcion' => $row[4] ?? null,
                'valor' => $this->parseCurrency($row[5] ?? 0),
                'valor_moneda' => $this->parseCurrency($row[6] ?? 0),
                'cliente_proveedor' => $row[7] ?? null,
                'nombre_cliente_proveedor' => $row[8] ?? null,
                'tercero' => $row[9] ?? null,
                'nombre_tercero' => $row[10] ?? null,
                'auxiliar' => $row[11] ?? null,
                'centro_costo' => $row[12] ?? null,
                'vendedor' => $row[13] ?? null,
                'tipo_doc' => $row[14] ?? null,
                'doc_factura' => $row[15] ?? null,
                'vencimiento' => $row[16] ?? null,
                'referencia' => $row[17] ?? null,
                'banco' => $row[18] ?? null,
                'plaza' => $row[19] ?? null,
                'zona' => $row[20] ?? null,
                'item' => $row[21] ?? null,
                'rubro_presupuesto' => $row[22] ?? null,
                'reserva_presupuestal' => $row[23] ?? null,
                'usuario' => $row[24] ?? null,
                'unidad_negocio' => $row[25] ?? null,
                'unidad1' => $row[26] ?? null,
                'unidad2' => $row[27] ?? null,
                'unidad3' => $row[28] ?? null,
                'c_ocupacion_ciiu' => $row[29] ?? null,
                'id_moneda_relacion' => $row[30] ?? null,
                'tasa_cambio_moneda_relacion' => $row[31] ?? null,
                'valor_moneda_relacion' => $row[32] ?? null,
                'linea_impuesto' => $row[33] ?? null,
                'sublinea_impuesto' => $row[34] ?? null,
                'codigo_propiedad1' => $row[35] ?? null,
                'codigo_propiedad2' => $row[36] ?? null,
                'codigo_propiedad3' => $row[37] ?? null,
                'codigo_propiedad4' => $row[38] ?? null,
                'codigo_propiedad5' => $row[39] ?? null,
                'adicional_1' => $row[40] ?? null,
                'adicional_2' => $row[41] ?? null,
                'ncf' => $row[42] ?? null,
                'consecutivo' => $row[43] ?? null,
            ]);
        }
    }

    private function parseCurrency($value)
    {
        if (!$value || trim($value) === '') return 0;

        // Check if negative (starts with parenthesis)
        $isNegative = str_starts_with($value, '(');

        // Remove symbols: $, (, ), spaces
        $value = str_replace(['$', '(', ')', ' '], '', $value);

        // Replace dots (thousands separator) with nothing, comma (decimal) with dot
        $value = str_replace(['.', ','], ['', '.'], $value);

        $floatValue = (float) $value;

        return $isNegative ? -$floatValue : $floatValue;
    }
}
