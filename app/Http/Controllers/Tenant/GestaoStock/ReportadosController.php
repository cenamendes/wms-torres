<?php

namespace App\Http\Controllers\Tenant\GestaoStock;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Models\Tenant\ReportadosStock;
use App\Models\Tenant\AnalisesReportadosAtualizados;
use Illuminate\Http\Request;

class ReportadosController extends Controller
{
    public function __construct()
    {
        // Construtor vazio
    }

    public function reportados(): View
    {
        return view('tenant.gestaostock.reportados', [
            'themeAction' => 'form_element_data_table',
            'status' => session('status'),
            'message' => session('message'),
        ]);
    }

    public function atualizarStatus($id, Request $request)
    {
        $reportar = ReportadosStock::findOrFail($id);
        $reportar->status = $request->status;
        $reportar->save();

        // Verifica se o status foi atualizado para "atualizado"
        if ($request->status === 'atualizado') {
            // Cria um novo registro na tabela "reportados_atualizados"
            AnalisesReportadosAtualizados::create([
                "document" => $reportar->document,
                "referencia" => $reportar->referencia,
                "observacao" => $reportar->observacao,
                "status" => "atualizado",
                "qtd_correta" => $reportar->qtd_correta,
                "created_at" => $reportar->created_at,
                "updated_at" => $reportar->updated_at,
            ]);

            // Exclui o registro da tabela "reportados_stock"
            $referencia = $reportar->referencia;
            ReportadosStock::where('referencia', $referencia)->delete();
        }

        return response()->json(['success' => true]);
    }

    public function excluirRegistros(Request $request)
    {
        $referencia = $request->referencia;


        ReportadosStock::where('referencia', $referencia)->delete();

        return response()->json(['success' => true]);
    }
}
