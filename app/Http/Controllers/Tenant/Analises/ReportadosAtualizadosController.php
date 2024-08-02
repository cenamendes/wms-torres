<?php

namespace App\Http\Controllers\Tenant\Analises;


use Illuminate\View\View;
use App\Models\Tenant\Analises;
use App\Http\Controllers\Controller;
use App\Interfaces\Tenant\Customers\CustomersInterface;


class ReportadosAtualizadosController extends Controller
{


    public function __construct()
    {

    }

    /**
     * Display the customers list.
     *
     * @return \Illuminate\View\View
     */


    public function reportadosatualizados(): View
    {
        return view('tenant.analises.reportadosatualizados', [
            'themeAction' => 'form_element_data_table',
            'status' => session('status'),
            'message' => session('message'),
        ]);
    }

}
