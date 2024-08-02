<?php

namespace App\Http\Livewire\Tenant\Arrumacoes;

use App\Interfaces\Tenant\Arrumacoes\ArrumacoesInterface;
use App\Models\Tenant\Config;
use App\Models\Tenant\Localizacoes;
use App\Models\Tenant\MovimentosStock;
use App\Models\Tenant\MovimentosStockTemporary;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowArrumacoesDetail extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $listeners = ["removeDosTemporarios" => "removeDosTemporarios", "EnviarMovimentosPrincipal" => "EnviarMovimentosPrincipal", "printEtiquetas" => "printEtiquetas"];

    public int $perPage;

    private ?object $referencias = null;

    /**Reduz stock **/
    public ?string $codbarras = '';
    public ?string $descricao = '';
    public ?string $qtd = '';

    public ?object $trs;
    public ?int $selectOrigin;
    public ?string $transferir;

    /************ */

    protected object $arrumacoesRepository;

    public function boot(ArrumacoesInterface $interfaceArrumacoes)
    {
        $this->arrumacoesRepository = $interfaceArrumacoes;
    }

    public function mount()
    {
        if (isset($this->perPage)) {
            session()->put('perPage', $this->perPage);
        } elseif (session('perPage')) {
            $this->perPage = session('perPage');
        } else {
            $this->perPage = 10;
        }

        $this->qtd = 1;

        $this->trs = Localizacoes::where('id', '!=', 1)->get();

        $this->transferir = '';

    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
        session()->put('perPage', $this->perPage);
    }

    public function updatedSearchString(): void
    {
        $this->resetPage();
    }

    public function updatedCodbarras()
    {
        $refs = $this->arrumacoesRepository->getArrumacoesCollection();

        foreach ($refs as $ref) {
            if ($ref["reference"] == $this->codbarras || $ref["cod_barras"] == $this->codbarras) {
                $this->descricao = $ref["designacao"];
            }
        }

        if ($this->codbarras == "") {
            $this->descricao = "";
        }

    }

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = substr(str_shuffle($characters), 0, $length);

        return $randomString;
    }

    public function guardaStock()
    {
        $array = [];
        $avisoQuantidadeExcedida = false;

        if ($this->transferir != "") {
            $locs = Localizacoes::where('cod_barras', $this->transferir)->first();

            if ($locs == null) {
                return to_route('tenant.arrumacoes.encomenda.detail')
                    ->with('message', 'Essa localização não existe!')
                    ->with('status', 'error');
            }

            if ($this->codbarras != "" && $this->descricao != "") {
                $refs = $this->arrumacoesRepository->getArrumacoesCollection();

                foreach ($refs as $i => $rf) {
                    $config = Config::first();

                    if ($config->cod_barras_accept == 0 && $config->reference_accept == 1) {
                        if ($rf["reference"] == $this->codbarras) {
                            $totalQuantity = $rf["qtd_inicial"] + $rf["qtd_separada"] + $rf["qtd_separada_recente"];

                            // Verificar se a nova quantidade ultrapassa a quantidade inicial
                            if (($totalQuantity + $this->qtd) > $rf["qtd_inicial"]) {
                                $avisoQuantidadeExcedida = true;
                            }

                            $id_localizacao = Localizacoes::where('cod_barras', $this->transferir)->first();

                            $number = $this->generateRandomString(8);

                            // Atualizar o registro MovimentosStockTemporary com a nova quantidade
                            MovimentosStockTemporary::where('id_movimento', $number)
                                ->update([
                                    "qtd_separada" => -$this->qtd,
                                    "localizacao" => 1,
                                ]);

                            MovimentosStockTemporary::create([
                                "id_movimento" => $number,
                                "nr_encomenda" => $rf["nr_encomenda"],
                                "cod_barras" => $rf["cod_barras"],
                                "reference" => $rf["reference"],
                                "qtd_separada" => $this->qtd,
                                "tipo" => "Transferencia",
                                "localizacao" => $id_localizacao->id,
                            ]);

                            // Atualizar a quantidade inicial
                            $rf->update([
                                "qtd_inicial" => $rf["qtd_inicial"] - $this->qtd,
                            ]);

                            // Verificar se a quantidade resultante é zero
                            if ($totalQuantity - $this->qtd == 0) {
                                return to_route('tenant.arrumacoes.encomenda.detail')
                                    ->with('message', 'A quantidade resultante é zero!')
                                    ->with('status', 'error');
                            }
                        }
                    } elseif ($config->cod_barras_accept == 1 && $config->reference_accept == 0) {
                        if ($rf["cod_barras"] == "") {
                            if ($rf["reference"] == $this->codbarras) {
                                if ($this->qtd > $rf["qtd"] || $rf["qtd"] == 0) {
                                    return to_route('tenant.arrumacoes.encomenda.detail')
                                        ->with('message', 'Essa quantidade ultrapassa o valor existente!')
                                        ->with('status', 'error');
                                }

                                $adicionado = MovimentosStockTemporary::where('nr_encomenda', $rf["nr_encomenda"])
                                ->where('reference', $rf["reference"])
                                ->where('localizacao',1)
                                ->get();

                                $soma = 0;

                                foreach ($adicionado as $item) {

                                    $soma += $item->qtd_separada;
                                }

                                $diferenca = intval($rf["qtd"]) + $soma - $this->qtd;

                                if (intval($diferenca) < intval(0)) {
                                    return to_route('tenant.arrumacoes.encomenda.detail')
                                        ->with('message', 'Essa quantidade ultrapassa o valor que tem na recção!')
                                        ->with('status', 'error');
                                }

                                $id_localizacao = Localizacoes::where('cod_barras', $this->transferir)->first();

                                $number = $this->generateRandomString(8);

                                MovimentosStockTemporary::create([
                                    "id_movimento" => $number,
                                    "nr_encomenda" => $rf["nr_encomenda"],
                                    "cod_barras" => $rf["cod_barras"],
                                    "reference" => $rf["reference"],
                                    "qtd_separada" => "-" . $this->qtd,
                                    "tipo" => "Transferencia",
                                    "localizacao" => 1,
                                ]);

                                MovimentosStockTemporary::create([
                                    "id_movimento" => $number,
                                    "nr_encomenda" => $rf["nr_encomenda"],
                                    "cod_barras" => $rf["cod_barras"],
                                    "reference" => $rf["reference"],
                                    "qtd_separada" => $this->qtd,
                                    "tipo" => "Transferencia",
                                    "localizacao" => $id_localizacao->id,
                                ]);

                            }

                        } else {
                            if ($rf["cod_barras"] == $this->codbarras) {
                                if ($this->qtd > $rf["qtd"] || $rf["qtd"] == 0) {
                                    return to_route('tenant.arrumacoes.encomenda.detail')
                                        ->with('message', 'Essa quantidade ultrapassa o valor existente!')
                                        ->with('status', 'error');
                                }

                                $adicionado = MovimentosStockTemporary::where('nr_encomenda', $rf["nr_encomenda"])
                                ->where('reference', $rf["reference"])
                                ->where('localizacao',1)
                                ->get();

                                $soma = 0;

                                foreach ($adicionado as $item) {

                                    $soma += $item->qtd_separada;
                                }


                                $diferenca = intval($rf["qtd"]) + $soma - $this->qtd;

                                if (intval($diferenca) < intval(0)) {
                                    return to_route('tenant.arrumacoes.encomenda.detail')
                                        ->with('message', 'Essa quantidade ultrapassa o valor que tem na recção!')
                                        ->with('status', 'error');
                                }

                                $id_localizacao = Localizacoes::where('cod_barras', $this->transferir)->first();

                                $number = $this->generateRandomString(8);

                                MovimentosStockTemporary::create([
                                    "id_movimento" => $number,
                                    "nr_encomenda" => $rf["nr_encomenda"],
                                    "cod_barras" => $rf["cod_barras"],
                                    "reference" => $rf["reference"],
                                    "qtd_separada" => "-" . $this->qtd,
                                    "tipo" => "Transferencia",
                                    "localizacao" => 1,
                                ]);

                                MovimentosStockTemporary::create([
                                    "id_movimento" => $number,
                                    "nr_encomenda" => $rf["nr_encomenda"],
                                    "cod_barras" => $rf["cod_barras"],
                                    "reference" => $rf["reference"],
                                    "qtd_separada" => $this->qtd,
                                    "tipo" => "Transferencia",
                                    "localizacao" => $id_localizacao->id,
                                ]);

                            }
                        }

                    } else {

                        if ($rf["cod_barras"] == "") {

                            if ($rf["reference"] == $this->codbarras) {

                                if ($rf["qtd"] <= 1) {
                                    return to_route('tenant.arrumacoes.encomenda.detail')
                                        ->with('message', 'Não há produtos na receção')
                                        ->with('status', 'error');
                                }

                                if ($this->qtd > $rf["qtd"] || $rf["qtd"] == 0) {
                                    return to_route('tenant.arrumacoes.encomenda.detail')
                                        ->with('message', 'Essa quantidade ultrapassa o valor existente!')
                                        ->with('status', 'error');
                                }

                                $adicionado = MovimentosStockTemporary::where('nr_encomenda', $rf["nr_encomenda"])
                                ->where('reference', $rf["reference"])
                                ->where('localizacao',1)
                                ->get();

                                $soma = 0;

                                foreach ($adicionado as $item) {

                                    $soma += $item->qtd_separada;
                                }


                                $diferenca = intval($rf["qtd"]) + $soma - $this->qtd;

                                if (intval($diferenca) < intval(0)) {
                                    return to_route('tenant.arrumacoes.encomenda.detail')
                                        ->with('message', 'Essa quantidade ultrapassa o valor que tem na recção!')
                                        ->with('status', 'error');
                                }


                                $id_localizacao = Localizacoes::where('cod_barras', $this->transferir)->first();

                                $number = $this->generateRandomString(8);

                                MovimentosStockTemporary::create([
                                    "id_movimento" => $number,
                                    "nr_encomenda" => $rf["nr_encomenda"],
                                    "cod_barras" => $rf["cod_barras"],
                                    "reference" => $rf["reference"],
                                    "qtd_separada" => "-" . $this->qtd,
                                    "tipo" => "Transferencia",
                                    "localizacao" => 1,
                                ]);

                                MovimentosStockTemporary::create([
                                    "id_movimento" => $number,
                                    "nr_encomenda" => $rf["nr_encomenda"],
                                    "cod_barras" => $rf["cod_barras"],
                                    "reference" => $rf["reference"],
                                    "qtd_separada" => $this->qtd,
                                    "tipo" => "Transferencia",
                                    "localizacao" => $id_localizacao->id,
                                ]);

                            }

                        } else {
                            if ($rf["cod_barras"] == $this->codbarras) {
                                if ($this->qtd > $rf["qtd"] || $rf["qtd"] == 0) {
                                    return to_route('tenant.arrumacoes.encomenda.detail')
                                        ->with('message', 'Essa quantidade ultrapassa o valor existente!')
                                        ->with('status', 'error');
                                }

                                $id_localizacao = Localizacoes::where('cod_barras', $this->transferir)->first();

                                $number = $this->generateRandomString(8);

                                MovimentosStockTemporary::create([
                                    "id_movimento" => $number,
                                    "nr_encomenda" => $rf["nr_encomenda"],
                                    "cod_barras" => $rf["cod_barras"],
                                    "reference" => $rf["reference"],
                                    "qtd_separada" => "-" . $this->qtd,
                                    "tipo" => "Transferencia",
                                    "localizacao" => 1,
                                ]);

                                MovimentosStockTemporary::create([
                                    "id_movimento" => $number,
                                    "nr_encomenda" => $rf["nr_encomenda"],
                                    "cod_barras" => $rf["cod_barras"],
                                    "reference" => $rf["reference"],
                                    "qtd_separada" => $this->qtd,
                                    "tipo" => "Transferencia",
                                    "localizacao" => $id_localizacao->id,
                                ]);

                            }
                        }

                    }

                }

                // Verificar se houve aviso de quantidade excedida
                if ($avisoQuantidadeExcedida) {
                    return to_route('tenant.arrumacoes.encomenda.detail')
                        ->with('message', 'A quantidade de Transferência ultrapassa o valor inicial!')
                        ->with('status', 'warning');
                }

                //$this->EnviarMovimentosPrincipal();
            } else {
                return to_route('tenant.arrumacoes.encomenda.detail')
                    ->with('message', 'Tem de adicionar uma referência existente!')
                    ->with('status', 'error');
            }
        }

        return to_route('tenant.arrumacoes.encomenda.detail')
            ->with('message', 'Quantidade alterada com sucesso')
            ->with('status', 'success');
    }

    // public function cancelarStock()
    // {
    //     MovimentosStockTemporary::where('tipo','Transferencia')->delete();

    //     return to_route('tenant.arrumacoes.encomenda.detail')
    //      ->with('message', 'Arrumado com sucesso')
    //      ->with('status', 'success');
    // }

    public function terminarStock()
    {
        $mov_temp = MovimentosStockTemporary::where('localizacao', '!=', 1)->where('tipo', 'Transferencia')->get();

        $message = '';

        $message = "<div class='swalBox'>";
        $message .= "<label>Transferências</label>";

        $message .= "<br><div class='row mt-4' id='divDate' style='justify-content:center;padding-left:15px;padding-right:15px;'>";
        $message .= " <table class='table-striped' style='width:100%;table-layout:fixed;'>";
        $message .= "<thead>";
        $message .= "<th style='padding-bottom: 10px;font-size:15px;'>Referencia</th>";
        $message .= "<th style='padding-bottom: 10px;font-size:15px;'>QTD</th>";
        $message .= "<th style='padding-bottom: 10px;font-size:15px;'>De</th>";
        $message .= "<th style='padding-bottom: 10px;font-size:15px;'>Ação</th>";
        $message .= "<th style='padding-bottom: 10px;font-size:15px;'>Para</th>";
        $message .= "</thead>";
        $message .= "<tbody>";
        foreach ($mov_temp as $mov) {
            $last_spot = MovimentosStockTemporary::where('id_movimento', $mov->id_movimento)->first();
            if ($last_spot != null) {
                $message .= "<tr style='text-align:center;'>";
                $message .= "<td style='font-size:15px;'><span>" . $mov->reference . "</span></td>";
                $message .= "<td style='font-size:15px;'><span>" . $mov->qtd_separada . "</span></td>";

                $response_last_location = Localizacoes::where('id', $last_spot->localizacao)->first();
                $message .= "<td style='font-size:15px;'><span>" . $response_last_location->abreviatura . "</span></td>";

                $message .= "<td style='font-size:15px;'><span><i class='fa fa-arrow-right' style='color:green;'></i></span></td>";
                $response_new_location = Localizacoes::where('id', $mov->localizacao)->first();
                $message .= "<td style='font-size:15px;'><span>" . $response_new_location->abreviatura . "</span></td>";
                // $message .= "<td style='font-size:15px;'><button type='button' id='btnLoc' style='border:none;background:none;' data-mov=".$mov->id."><i class='fa fa-xmark' style='color:red;'></i></button></td>";

                $message .= "</tr>";
            }

        }
        $message .= "</tbody>";
        $message .= "</table>";
        $message .= "</div>";

        $message .= "</div>";

        $this->dispatchBrowserEvent('terminarStock', ['title' => "Verificar Movimentos", 'message' => $message, 'status' => 'info']);
    }

    public function removeDosTemporarios($id)
    {
        MovimentosStockTemporary::where('id', $id)->delete();

        $this->terminarStock();
    }

    public function EnviarMovimentosPrincipal()
    {
        $response = MovimentosStockTemporary::where('tipo', 'Transferencia')->get();

        if ($response == null) {
            return to_route('tenant.arrumacoes.encomenda.detail')
                ->with('message', 'Não contem movimentos!')
                ->with('status', 'error');
        }

        if ($response->count() > 0) {
            foreach ($response as $resp) {
                MovimentosStock::create([
                    "id_movimento" => $resp->id_movimento,
                    "nr_encomenda" => $resp->nr_encomenda,
                    "cod_barras" => $resp->cod_barras,
                    "reference" => $resp->reference,
                    "qtd" => $resp->qtd_separada,
                    "tipo" => $resp->tipo,
                    "localizacao" => $resp->localizacao,
                ]);

                MovimentosStockTemporary::where("nr_encomenda", $resp->nr_encomenda)->update([
                    "concluded_movement" => 1,
                ]);
            }

            MovimentosStockTemporary::where('tipo', 'Transferencia')->delete();
        }

        return to_route('tenant.arrumacoes.encomenda.detail')
            ->with('message', 'Arrumado com sucesso')
            ->with('status', 'success');
    }

    public function printEtiquetas($object)
    {
        $object_decoded = json_decode($object);

        //$variable = strtok($object_decoded["nr_encomenda"], '|');

        //Passar no parametro o objecto

        $new_array = [];

        for ($i = 1; $i <= $object_decoded->qtd; $i++) {
            $new_array[$i] = [
                "nr_encomenda" => $object_decoded->nr_encomenda,
                "cod_barras" => $object_decoded->cod_barras,
                "reference" => $object_decoded->reference,
                "designacao" => $object_decoded->designacao,
                "qtd" => 1,
                "local" => $object_decoded->local,
            ];

        }

        $customPaper = array(0, 0, 504.00, 216.00);
        $pdf = PDF::loadView('tenant.livewire.arrumacoes.multiimpressaopdf', ["object" => $new_array])->setPaper($customPaper);

        //guardar ficheiro
        //depois dar redirect para o ficheiro para dar preview

        if (!Storage::exists(tenant('id') . '/app/stockArrumacoes')) {
            File::makeDirectory(storage_path('app/stockArrumacoes'), 0755, true, true);
        }

        $content = $pdf->download()->getOriginalContent();
        Storage::put(tenant('id') . '/app/stockArrumacoes/etiqueta.pdf', $content);

        $this->dispatchBrowserEvent('redirectPage', ["tenant" => tenant('id')]);
    }

    public function paginationView()
    {
        return 'tenant.livewire.setup.pagination';
    }

    public function render()
    {
        // **  Numero de encomendas de fornecedor abertos  **/

        $this->referencias = $this->arrumacoesRepository->getArrumacoes($this->perPage);

        return view('tenant.livewire.arrumacoes.arrumacaodetail', ["referencias" => $this->referencias, "trs" => $this->trs]);
    }
}
