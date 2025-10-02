<?php

namespace App\Console\Commands;

use App\Models\CentroCostoSeccion;
use Illuminate\Console\Command;

class CargarCentrosCosto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'centros:cargar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cargar datos iniciales de centros de costo y secciones';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando carga de centros de costo...');

        $datos = [
            ['centro_costo' => '130101', 'rubro' => 'CAP PROG BACHILLERATO INTERNACIONAL', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130102', 'rubro' => 'CAP PROG BACHILLERATO INTERNACIONAL', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130103', 'rubro' => 'CAP PROG BACHILLERATO INTERNACIONAL', 'seccion' => 'MEDIA'],
            ['centro_costo' => '130104', 'rubro' => 'CAP PROG BACHILLERATO INTERNACIONAL', 'seccion' => 'ALTA'],
            ['centro_costo' => '130201', 'rubro' => 'CAPACITACIONES OTROS', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130202', 'rubro' => 'CAPACITACIONES OTROS', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130203', 'rubro' => 'CAPACITACIONES OTROS', 'seccion' => 'MEDIA'],
            ['centro_costo' => '130204', 'rubro' => 'CAPACITACIONES OTROS', 'seccion' => 'ALTA'],
            ['centro_costo' => '130205', 'rubro' => 'CAPACITACIONES OTROS', 'seccion' => 'PEP'],
            ['centro_costo' => '130301', 'rubro' => 'MATERIAL IMPORTADO', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130302', 'rubro' => 'MATERIAL IMPORTADO', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130303', 'rubro' => 'MATERIAL IMPORTADO', 'seccion' => 'MEDIA'],
            ['centro_costo' => '130304', 'rubro' => 'MATERIAL IMPORTADO', 'seccion' => 'ALTA'],
            ['centro_costo' => '130305', 'rubro' => 'MATERIAL IMPORTADO', 'seccion' => 'PEP'],
            ['centro_costo' => '130401', 'rubro' => 'BIBLIOTECA', 'seccion' => 'BIBLIOTECA'],
            ['centro_costo' => '130402', 'rubro' => 'BIBLIOTECA', 'seccion' => 'BIBLIOTECA'],
            ['centro_costo' => '130403', 'rubro' => 'BIBLIOTECA', 'seccion' => 'BIBLIOTECA'],
            ['centro_costo' => '130404', 'rubro' => 'BIBLIOTECA', 'seccion' => 'BIBLIOTECA'],
            ['centro_costo' => '130405', 'rubro' => 'BIBLIOTECA', 'seccion' => 'BIBLIOTECA'],
            ['centro_costo' => '130406', 'rubro' => 'BIBLIOTECA', 'seccion' => 'BIBLIOTECA'],
            ['centro_costo' => '130501', 'rubro' => 'MATERIALES', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130502', 'rubro' => 'MATERIALES', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130503', 'rubro' => 'MATERIALES', 'seccion' => 'MEDIA'],
            ['centro_costo' => '130504', 'rubro' => 'MATERIALES', 'seccion' => 'ALTA'],
            ['centro_costo' => '130601', 'rubro' => 'DEPORTES', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130602', 'rubro' => 'DEPORTES', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130603', 'rubro' => 'DEPORTES', 'seccion' => 'MEDIA'],
            ['centro_costo' => '130604', 'rubro' => 'DEPORTES', 'seccion' => 'ALTA'],
            ['centro_costo' => '130605', 'rubro' => 'DEPORTES', 'seccion' => 'DEPORTES ACADEMIA'],
            ['centro_costo' => '130701', 'rubro' => 'MUSICALES', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130702', 'rubro' => 'MUSICALES', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130703', 'rubro' => 'MUSICALES', 'seccion' => 'MEDIA'],
            ['centro_costo' => '130704', 'rubro' => 'MUSICALES', 'seccion' => 'ALTA'],
            ['centro_costo' => '130801', 'rubro' => 'PART TIME TEACHER/ REEMPLAZOS', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130802', 'rubro' => 'PART TIME TEACHER/ REEMPLAZOS', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130803', 'rubro' => 'PART TIME TEACHER/ REEMPLAZOS', 'seccion' => 'MEDIA'],
            ['centro_costo' => '130804', 'rubro' => 'PART TIME TEACHER/ REEMPLAZOS', 'seccion' => 'ALTA'],
            ['centro_costo' => '130901', 'rubro' => 'DOTACION', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130902', 'rubro' => 'DOTACION', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '130903', 'rubro' => 'DOTACION', 'seccion' => 'MEDIA'],
            ['centro_costo' => '130904', 'rubro' => 'DOTACION', 'seccion' => 'ALTA'],
            ['centro_costo' => '131001', 'rubro' => 'EXHIBITION PEP', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '131101', 'rubro' => 'PERSONAL PROYEC PAI', 'seccion' => 'PAI'],
            ['centro_costo' => '131201', 'rubro' => 'CAS/INTERCAS/PROYECTO COMUNITARIO', 'seccion' => 'CAS'],
            ['centro_costo' => '131202', 'rubro' => 'CAS/INTERCAS/PROYECTO COMUNITARIO', 'seccion' => 'CAS'],
            ['centro_costo' => '131203', 'rubro' => 'CAS/INTERCAS/PROYECTO COMUNITARIO', 'seccion' => 'CAS'],
            ['centro_costo' => '131204', 'rubro' => 'CAS/INTERCAS/PROYECTO COMUNITARIO', 'seccion' => 'CAS'],
            ['centro_costo' => '131301', 'rubro' => 'PRAE', 'seccion' => 'BIENESTAR INSTITUCIONAL'],
            ['centro_costo' => '131401', 'rubro' => 'MODELO NACIONES UNIDAS TVS', 'seccion' => 'MUN TVS'],
            ['centro_costo' => '131501', 'rubro' => 'MUN OTROS COLEGIOS', 'seccion' => 'MUN OTROS COLEGIOS'],
            ['centro_costo' => '131601', 'rubro' => 'CONSEJERIA UNIVERSITARIA', 'seccion' => 'CONSEJERIA UNIVERSITARIA'],
            ['centro_costo' => '131701', 'rubro' => 'EXHIBITION DE ARTE', 'seccion' => 'EXHIBITION DE ARTE'],
            ['centro_costo' => '131801', 'rubro' => 'PSICOLOGIA INSTITUCIONAL', 'seccion' => 'PSICOLOGIA INSTITUCIONAL'],
            ['centro_costo' => '131802', 'rubro' => 'PSICOLOGIA INSTITUCIONAL', 'seccion' => 'PSICOLOGIA INSTITUCIONAL'],
            ['centro_costo' => '131803', 'rubro' => 'PSICOLOGIA INSTITUCIONAL', 'seccion' => 'PSICOLOGIA INSTITUCIONAL'],
            ['centro_costo' => '131901', 'rubro' => 'TECNOLOGIA Y AUDIVISUALES', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '131902', 'rubro' => 'TECNOLOGIA Y AUDIVISUALES', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '131903', 'rubro' => 'TECNOLOGIA Y AUDIVISUALES', 'seccion' => 'ALTA'],
            ['centro_costo' => '131904', 'rubro' => 'TECNOLOGIA Y AUDIVISUALES', 'seccion' => 'MEDIA'],
            ['centro_costo' => '132001', 'rubro' => 'EVENTOS Y AGASAJOS', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '132002', 'rubro' => 'EVENTOS Y AGASAJOS', 'seccion' => 'PREESCOLAR Y PRIMARIA'],
            ['centro_costo' => '132003', 'rubro' => 'EVENTOS Y AGASAJOS', 'seccion' => 'MEDIA'],
            ['centro_costo' => '132004', 'rubro' => 'EVENTOS Y AGASAJOS', 'seccion' => 'ALTA'],
            ['centro_costo' => '132005', 'rubro' => 'EVENTOS Y AGASAJOS', 'seccion' => 'DIRECCION GENERAL'],
            ['centro_costo' => '132101', 'rubro' => 'CURSO PREICFES', 'seccion' => 'CURSO PREICFES']
        ];

        $bar = $this->output->createProgressBar(count($datos));
        $bar->start();

        $contador = 0;
        foreach ($datos as $dato) {
            try {
                CentroCostoSeccion::updateOrCreate(
                    ['centro_costo' => $dato['centro_costo']], 
                    $dato
                );
                $contador++;
                $bar->advance();
            } catch (\Exception $e) {
                $this->error("Error procesando {$dato['centro_costo']}: " . $e->getMessage());
            }
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("✅ Proceso completado! Se procesaron {$contador} registros de centros de costo.");
        
        return Command::SUCCESS;
    }
}
