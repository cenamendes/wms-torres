<?php

namespace App\Http\Livewire\Tenant\Encomendas;

use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Mail\Report\ReportStock;
use App\Models\Tenant\AnalisesPicking;
use App\Models\Tenant\Config;
use App\Models\Tenant\MovimentosStock;
use App\Models\Tenant\MovimentosStockTemporary;
use App\Models\Tenant\ReportadosStock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowRececaoDetail extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $listeners = ["removeDosTemporariosRececao" => "removeDosTemporariosRececao", "EnviarMovimentosPrincipalRececao" => "EnviarMovimentosPrincipalRececao", "enviarImpressao" => "enviarImpressao", 'reportarStockConfirm' => 'reportarStockConfirm'];

    public int $perPage;

    public $selectoptions = [];

    public $selectcheck = [];
    public $quantidadeCorreta;
    public $observacoes;

    public $report_email;
    public $referencias_reportadas;

    private ?object $encomendaSpecific = null;

    private ?string $encomendaDocument = null;

    /**Detail */
    public string $encomenda = '';
    public string $stringEncomenda = '';
    /*** */
    /**Reduz stock **/
    public ?string $codbarras = '';
    public ?string $descricao = '';
    public ?string $qtd = '';
    public ?string $qtdstock = '';
    /************ */

    protected object $encomendaRepository;

    public function boot(EncomendasInterface $interfaceEncomenda)
    {
        $this->encomendaRepository = $interfaceEncomenda;
    }

    public function mount($encomenda)
    {
        if (isset($this->perPage)) {
            session()->put('perPage', $this->perPage);
        } elseif (session('perPage')) {
            $this->perPage = session('perPage');
        } else {
            $this->perPage = 10;
        }

        $this->encomenda = $encomenda;

        $this->qtd = 1;

        $this->encomendaSpecific = $this->encomendaRepository->detalhesCodBarras($this->encomenda, $this->perPage);

        $this->encomendaDocument = $this->encomendaRepository->entradaNumEncomenda($this->encomenda);

        $this->referencias_reportadas = ReportadosStock::pluck('referencia')->toArray();

    }

    public function paginationView()
    {
        return 'tenant.livewire.setup.pagination';
    }

    public function updatedCodbarras()
    {

        $encspe = $this->encomendaRepository->conferecod($this->encomenda);

        $config = Config::first();

        if ($config->cod_barras_accept == 0 && $config->reference_accept == 1) {
            foreach ($encspe->lines as $line) {
                if ($this->codbarras == $line->referense) {
                    $this->descricao = $line->design;
                    $this->qtdstock = $this->encomendaRepository->entradaQtdStock($line->referense);
                }

            }

        } else if ($config->cod_barras_accept == 1 && $config->reference_accept == 0) {
            foreach ($encspe->lines as $line) {
                if ($this->codbarras == $line->barcode) {
                    $this->descricao = $line->design;
                    $this->qtdstock = $this->encomendaRepository->entradaQtdStock($line->referense);
                }

            }

        } else {
            foreach ($encspe->lines as $line) {
                if ($this->codbarras == $line->barcode || $this->codbarras == $line->referense) {
                    $this->descricao = $line->design;
                    $this->qtdstock = $this->encomendaRepository->entradaQtdStock($line->referense);
                }

            }
        }

        if ($this->codbarras == "") {
            $this->descricao = "";
        } else {
            if ($this->descricao == "") {
                // return to_route('tenant.encomendas.encomendadetail', $this->encomenda)
                //     ->with('message', 'Referencia inexistente ou verifique se esta com espaços!')
                //     ->with('status', 'error');
                $this->dispatchBrowserEvent('menssageerror', ['message' => 'Referencia inexistente ou verifique se esta com espaços!', 'status' => 'error']);
            }
        }

    }

    public function guardaStock()
    {
        $envguard = $this->encomendaRepository->guardstock($this->encomenda);
        $array = [];

        if ($this->codbarras != "" && $this->descricao != "" && $this->qtd != "") {

            if ($this->qtd <= 0) {
                // return to_route('tenant.encomendas.encomendadetail', $this->encomenda)
                //     ->with('message', 'A quantidade deve ser maior que zero!')
                //     ->with('status', 'error');
                $this->dispatchBrowserEvent('menssageerror', ['message' => 'A quantidade deve ser maior que zero!', 'status' => 'error']);
            }

            $config = Config::first();
            $referenceGet = "";

            if ($config->cod_barras_accept == 0 && $config->reference_accept == 1) {
                foreach ($envguard->lines as $line) {
                    if ($this->codbarras == $line->referense) {
                        $referenceGet = $line->referense;
                    }
                }
            } else if ($config->cod_barras_accept == 1 && $config->reference_accept == 0) {
                foreach ($envguard->lines as $line) {
                    if ($this->codbarras == $line->barcode) {
                        $referenceGet = $line->referense;
                    }
                }
            } else {
                foreach ($envguard->lines as $line) {
                    if ($this->codbarras == $line->barcode || $this->codbarras == $line->referense) {
                        $referenceGet = $line->referense;
                    }
                }
            }

            if ($referenceGet == "") {
                // return to_route('tenant.encomendas.encomendadetail', $this->encomenda)
                //     ->with('message', 'Essa referência não existe!')
                //     ->with('status', 'error');
                $this->dispatchBrowserEvent('menssageerror', ['message' => 'Essa referência não existe!', 'status' => 'error']);
                return false;
            }

            $soma = 0;
            $checkbanc = MovimentosStockTemporary::where('numero_encomenda', $this->encomenda)->Where('referencia', $referenceGet)->get();

            if (empty($checkbanc)) {
                foreach ($envguard->lines as $line) {
                    if ($line->referense == $referenceGet) {
                        if ($this->qtd > $line->quantity) {
                            // return to_route('tenant.encomendas.encomendadetail', $this->encomenda)
                            //     ->with('message', 'Essa quantidade já ultrapassou a quantidade da Encomenda!')
                            //     ->with('status', 'error');
                            $this->dispatchBrowserEvent('menssageerror', ['message' => 'Essa quantidade já ultrapassou a quantidade da Encomenda!', 'status' => 'error']);

                        }

                        MovimentosStockTemporary::create([
                            "numero_encomenda" => $this->encomenda,
                            "id_line" => $line->id_line,
                            "document" => $line->document,
                            "referencia" => $line->referense,
                            "barcode" => $line->barcode,
                            "descricao" => $line->design,
                            "qtd_registrada" => $this->qtd,
                            "warehouse" => $line->warehouse,
                        ]);

                        $this->dispatchBrowserEvent('menssagesucess', ['message' => 'Quantidade Separada foi alterada!', 'status' => 'sucess']);
                    }
                }
            } else {
                foreach ($checkbanc as $line) {
                    $soma += $line->qtd_registrada;
                }

                $soma = $soma + $this->qtd;

                foreach ($envguard->lines as $line) {
                    if ($line->referense == $referenceGet) {
                        if ($soma > $line->quantity) {
                            // return to_route('tenant.encomendas.encomendadetail', $this->encomenda)
                            //     ->with('message', 'Essa quantidade já ultrapassa a quantidade da Encomenda!')
                            //     ->with('status', 'error');
                            $this->dispatchBrowserEvent('menssageerror', ['message' => 'Essa quantidade já ultrapassa a quantidade da Encomenda!', 'status' => 'error']);
                        }

                        $sumQtdSeparada = MovimentosStock::where('numero_encomenda', $this->encomenda)
                            ->where('referencia', $referenceGet)
                            ->sum('qtd_separada');

                        $sumQtdtemporary = MovimentosStockTemporary::where('numero_encomenda', $this->encomenda)
                            ->where('referencia', $referenceGet)
                            ->sum('qtd_registrada');

                        foreach ($envguard->lines as $line) {
                            if ($line->referense == $referenceGet) {
                                $totalQtdSeparada = $sumQtdSeparada + $this->qtd + $sumQtdtemporary;

                                if ($totalQtdSeparada > $line->quantity) {
                                    $this->dispatchBrowserEvent('menssageerror', ['message' => 'Essa quantidade já ultrapassa a quantidade Separada!', 'status' => 'error']);
                                }

                                MovimentosStockTemporary::create([
                                    "numero_encomenda" => $this->encomenda,
                                    "id_line" => $line->id_line,
                                    "document" => $line->document,
                                    "referencia" => $line->referense,
                                    "barcode" => $line->barcode,
                                    "descricao" => $line->design,
                                    "qtd_registrada" => $this->qtd,
                                    "warehouse" => $line->warehouse,
                                ]);

                            }
                        }
                    }
                }
                // session(['message' =>'Quantidade Separada Adicionada!']);
                // session(['status' =>'sucess!']);
                $this->dispatchBrowserEvent('menssagesucess', ['message' => 'Quantidade Separada Adicionada!', 'status' => 'sucess']);
                return false;

            }
            // return to_route('tenant.encomendas.encomendadetail', $this->encomenda)
            //     ->with('message', 'Todos os campos (cód. barras, descrição, quantidade) devem ser preenchidos!')
            //     ->with('status', 'error');
            $this->dispatchBrowserEvent('menssageerror', ['message' => 'Todos os campos (cód. barras, descrição, quantidade) devem ser preenchidos!', 'status' => 'error']);
        }
    }

    public function terminarStock()
    {
        $mov_temp = MovimentosStockTemporary::where('numero_encomenda', $this->encomenda)->get();

        // Array para armazenar a quantidade total separada e em estoque para cada referência
        $referencias = [];

        $message = "<div class='swalBox'>";
        $message .= "<label>Transferências</label>";

        $message .= "<br><div class='row mt-4' id='divDate' style='position: relative; width: 100%; overflow-x: hidden;'>";
        $message .= "<div style='max-height: 200px; overflow-y: auto;'>"; // Adiciona o scroll vertical aqui
        $message .= "<table class='table-striped' style='width:100%; table-layout:fixed; min-width: 25rem !important;'>";
        $message .= "<thead style='position: sticky; top: 0; background-color: white;'>"; // Cabeçalho fixo
        $message .= "<th style='padding-bottom: 10px;font-size:15px; text-align:center;'>Encomenda</th>";
        $message .= "<th style='padding-bottom: 10px;font-size:15px; text-align:center;'>Referência</th>";
        $message .= "<th style='padding-bottom: 10px;font-size:15px; text-align:center;'>QTD Separada</th>";
        $message .= "</thead>";
        $message .= "<tbody style='max-height: 200px; overflow-y: auto;'>"; // Adiciona o scroll vertical apenas aqui

        foreach ($mov_temp as $mov) {
            // Adicione a quantidade separada à referência correspondente no array
            if (!isset($referencias[$mov->referencia])) {
                $referencias[$mov->referencia] = [
                    'qtd_separada' => 0,
                    'qtd_estoque' => 0,
                ];
            }
            $referencias[$mov->referencia]['qtd_separada'] += $mov->qtd_registrada;

            // Obtenha a quantidade em estoque para esta referência
            $qtd_estoque = $this->encomendaRepository->entradaQtdStock($mov->referencia);
            $referencias[$mov->referencia]['qtd_estoque'] = $qtd_estoque;

            $message .= "<tr style='text-align:center;'>";
            $message .= "<td style='font-size:15px; padding:0px 10px;'><span>" . $mov->document . "</span></td>";
            $message .= "<td style='font-size:15px; padding:0px 5px;'><span>" . $mov->referencia . "</span></td>";
            $message .= "<td style='font-size:15px; padding:0px 10px;'><span>" . $mov->qtd_registrada . "</span></td>";
            $message .= "</tr>";
        }
        $message .= "</tbody>";
        $message .= "</table>";
        $message .= "</div>"; // Fecha a div com scroll
        $message .= "</div>";

        // Construa a segunda tabela com as quantidades previstas e em estoque
        $message .= "<br><div class='row mt-4' id='divDate' style=' position: relative;
    width: 100%;
    overflow-x: auto;'>";
        $message .= "<div style='max-height: 200px; overflow-y: auto;'>"; // Adiciona o scroll aqui
        $message .= "<table class='table-striped' style='width:100%; table-layout:fixed; min-width: 25rem !important;'>";
        $message .= "<thead>";
        $message .= "<th style='padding-bottom: 10px;font-size:15px; text-align:center;'>Referência</th>";
        $message .= "<th style='padding-bottom: 10px;font-size:15px; text-align:center;'>QTD Prevista</th>";
        $message .= "</thead>";
        $message .= "<tbody>";

        foreach ($referencias as $referencia => $dados) {
            $qtd_prevista = $dados['qtd_separada'] + $dados['qtd_estoque'];

            $message .= "<tr style='text-align:center;'>";
            $message .= "<td style='font-size:15px; padding:0px 5px;'><span>" . $referencia . "</span></td>";
            $message .= "<td style='font-size:15px; padding:0px 10px;'><span>" . $qtd_prevista . "</span></td>";
            $message .= "</tr>";
        }
        $message .= "</tbody>";
        $message .= "</table>";
        $message .= "</div>"; // Fecha a div com scroll
        $message .= "</div>";

        $message .= "</div>";

        $this->dispatchBrowserEvent('terminarStock', ['title' => "Envio da QTD Adicionada", 'message' => $message]);
    }

    public function cancelarStock()
    {
        $mov_temp = MovimentosStockTemporary::where('numero_encomenda', $this->encomenda)->get();

        // Verifica se há movimentos temporários
        if ($mov_temp->isEmpty()) {
            // Se não houver movimentos temporários, apenas redirecione sem fazer nada
            // return redirect()->route('tenant.encomendas.encomendadetail', $this->encomenda);
            $this->dispatchBrowserEvent('menssageerror', ['message' => 'Não a encomendas adicionadas.', 'status' => 'error']);
            return false;
        }

        // Se houver movimentos temporários, exclui-os e mostra o popup
        MovimentosStockTemporary::where('numero_encomenda', $this->encomenda)->delete();

        // return to_route('tenant.encomendas.encomendadetail', $this->encomenda)
        //     ->with('message', 'Todas as quantidades adicionadas dessa encomenda foram canceladas!')
        //     ->with('status', 'sucess');
        $this->dispatchBrowserEvent('menssagecencel', ['message' => 'Quantidades adicionadas da encomenda foram canceladas!', 'status' => 'sucess']);
    }

    public function reportarStock()
    {
        if (!empty($this->codbarras)) {

            $message = ' <p class="custom-label">Referência: </p>
            <p>' . $this->codbarras . '</p>
            <p class="custom-label">Quantidade no Stock: </p>
            <p>' . $this->qtdstock . '</p>
            <label for="quantidadeCorreta" class="custom-label">Quantidade Correta:</label>
            <br>
            <input type="number" id="quantidadeCorreta" class="swal2-input">
            <br>
            <label for="observacoes" class="custom-label">Observações:</label>
            <textarea id="observacoes" class="swal2-textarea" placeholder="Digite suas observações aqui..."></textarea>
            ';

            $EmailReportarStock = Config::first();

            $this->dispatchBrowserEvent('reportarDadosStock', ['email' => $EmailReportarStock->report_email, 'message' => $message, 'dadosreportereference' => $this->codbarras, 'dadosreporteqtsstock' => $this->qtdstock, 'status' => 'info']);
        }
    }

    public function reportarStockConfirm($quantidadeCorreta, $observacoes, $report_email)
    {
        // Verifica se a quantidade correta é um número inteiro
        if (!ctype_digit($quantidadeCorreta)) {
            // return redirect()->back()->with('message', 'A quantidade correta deve ser um número inteiro.')->with('status', 'error');
            $this->dispatchBrowserEvent('menssageerror', ['message' => 'A quantidade correta deve ser um número inteiro.', 'status' => 'error']);

        }

        // Verifica se a quantidade correta é maior ou igual a zero
        if ($quantidadeCorreta < 0) {
            // return redirect()->back()->with('message', 'A quantidade correta não pode ser menor que zero.')->with('status', 'error');
            $this->dispatchBrowserEvent('menssageerror', ['message' => 'A quantidade correta não pode ser menor que zero.', 'status' => 'error']);
            return false;
        }

        $this->quantidadeCorreta = $quantidadeCorreta;
        $this->observacoes = $observacoes;

        // Verifique se o e-mail não está vazio antes de enviar o e-mail
        if ($report_email) {

            // Salvar os dados na tabela "analises_reportados"
            ReportadosStock::create([
                'referencia' => $this->codbarras,
                'qtd_correta' => $this->quantidadeCorreta,
                'observacao' => $this->observacoes,
                'status' => 'reportado',
            ]);

            // Agora você pode usar essas variáveis como desejar, por exemplo, enviá-las por e-mail
            Mail::to($report_email)->queue(new ReportStock($this->quantidadeCorreta, $this->observacoes, $report_email));
        }

        // return redirect()->route('tenant.encomendas.encomendadetail', $this->encomenda)
        //     ->with('message', 'Reportado com Sucesso!')
        //     ->with('status', 'success');

        $this->dispatchBrowserEvent('menssagesucess', ['message' => 'Reportado com Sucesso!', 'status' => 'sucess']);

    }

    public function EnviarMovimentosPrincipalRececao()
    {
        $movimentosStockTemporarios = MovimentosStockTemporary::where('numero_encomenda', $this->encomenda)
            ->where('qtd_registrada', '!=', '0')
            ->get();

        if ($movimentosStockTemporarios->isEmpty()) {
            return redirect()->route('tenant.encomendas.encomendadetail', $this->encomenda)
                ->with('message', 'Nenhum Dado encontrado para envio.')
                ->with('status', 'error');
        }

        foreach ($movimentosStockTemporarios as $movimentoStock) {
            // Criar movimento na tabela movimentos_stock
            MovimentosStock::create([
                "numero_encomenda" => $movimentoStock->numero_encomenda,
                "id_line" => $movimentoStock->id_line,
                "document" => $movimentoStock->document,
                "referencia" => $movimentoStock->referencia,
                "barcode" => $movimentoStock->barcode,
                "descricao" => $movimentoStock->descricao,
                "locais_stock" => "REC",
                "estado" => "Entrada",
                "qtd_separada" => $movimentoStock->qtd_registrada,
                "warehouse" => $movimentoStock->warehouse,
            ]);

            AnalisesPicking::create([
                "numero_encomenda" => $movimentoStock->numero_encomenda,
                "document" => $movimentoStock->document,
                "referencia" => $movimentoStock->referencia,
                "descricao" => $movimentoStock->descricao,
                "locais_stock" => "REC",
                "estado" => "Entrada",
                "qtd_separada" => $movimentoStock->qtd_registrada,
            ]);
        }

        MovimentosStockTemporary::where('numero_encomenda', $this->encomenda)->delete();

        return redirect()->route('tenant.encomendas.encomendadetail', $this->encomenda)
            ->with('message', 'Arrumada com sucesso a Quantidade Separada')
            ->with('status', 'sucesso');
    }

    public function detalhesimpressao($numeroencomenda, $referense, $quantity, $design, $barcode)
    {
        $message = "<div class='swalBox'>";
        $title = "<h3 style='color:white; font-size:1.8rem; font-weight: 600;'>Imprimir</h3>";
        $message .= "<h4 style='color:white; font-weight: 600;'>Número da Encomenda: </h4> <p style='color:#edebeb; font-weight: 400;'>" . $numeroencomenda . "</p>";
        $message .= "<h4 style='color:white; font-weight: 600;'>Número da Referência: </h4> <p style='color:#edebeb; font-weight: 400;'>" . $referense . "</p>";
        $message .= "<h4 style='color:white; font-weight: 600;'>Descrição: </h4> <p style='color:#edebeb; font-weight: 400;'> " . $design . "</p>";
        $message .= "<label style='color:white; font-weight: 600;'>Imprimir: ";
        $message .= "<input type='number' id='qtdimpre' value=" . $quantity . " style='border: 0.1rem solid white; border-radius: 0.2rem; padding:0.4rem; width: 8rem;' >";
        $message .= "</label>";

        $this->dispatchBrowserEvent('detalhesimpressao', [
            'title' => $title,
            'message' => $message,
            'status' => 'info',
            'numeroencomenda' => $numeroencomenda,
            'referense' => $referense,
            'design' => $design,
            'quantity' => $quantity,
            'barcode' => $barcode,
        ]);

    }

    //Impressão
    public function enviarImpressao($quantity, $design, $barcode)
    {

        $ip = env('APP_IP_PRINTER');
        $port = 9100;

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        if ($socket === false) {
            return "Não foi possível criar o socket: " . socket_strerror(socket_last_error());
        }

        $result = socket_connect($socket, $ip, $port);

        if ($result === false) {
            socket_close($socket);
            return "Não foi possível conectar-se à impressora: " . socket_strerror(socket_last_error());
        }

        // Dados para o código de barras
        $codebarData = $barcode;

        if (empty($barcode)) {
            return "A sequência fornecida não é válida para um código de barras.";
        }

        // Comando EPL2 com texto e código de barras
        $epl2Command = "N\n";

        for ($i = 0; $i < $quantity; $i++) {
            // Adicione mais cópias conforme necessário
            $epl2Command .= "A125,325,0,1,1,2,N,\"$design\"\n"; // Adiciona a descrição acima do código de barras
            $epl2Command .= "B150,355,0,1E,2,2,100,N,\"$codebarData\"\n"; // Código de barras
            $epl2Command .= "A225,455,0,1,1,2,N,\"$barcode\"\n"; // Código de barras numeros
        }

        $epl2Command .= "P$quantity\n";

        // Tente enviar o comando EPL2 para a impressora
        $bytesSent = socket_write($socket, $epl2Command, strlen($epl2Command));

        // Verifique se o envio foi bem-sucedido
        if ($bytesSent === false) {
            socket_close($socket);
            return "Erro ao enviar comando para a impressora: " . socket_strerror(socket_last_error());
        }

        socket_close($socket);

        return "Impressão enviada com sucesso!";
    }

    public $referenciasSelecionadas = [];

    public function selecionarCheck($numeroencomenda, $referencias, $soma)
    {
        $this->referenciasSelecionadas[] = [
            'referencias' => $referencias,
            'numeroencomenda' => $numeroencomenda,
            'soma' => $soma,
        ];

    }

    //CHECK IMPRESSÃO
    public function impressaoMassa()
    {

        // Verificar se pelo menos um checkbox está marcado
        $checkboxMarcado = false;
        foreach ($this->selectoptions as $ref => $state) {
            if ($state == true) {
                $checkboxMarcado = true;
                break;
            }
        }

        if (!$checkboxMarcado) {
            // Emitir swal error se nenhum checkbox estiver marcado
            $this->emit('swal:error', ['title' => 'Erro!', 'text' => 'Selecione pelo menos um check para imprimir.']);
            return;
        }

        $contcheck = $this->encomendaRepository->checkmassa($this->encomenda);

        $ip = env('APP_IP_PRINTER');
        $port = 9100;

        foreach ($contcheck->lines as $checkcont) {

            foreach ($this->selectoptions as $ref => $state) {

                if ($state == true) {
                    $items = $this->encomendaRepository->encomendaImprimir(
                        $this->encomenda,
                        $ref
                    );

                    if ($ref == $checkcont->referense) {

                        // Loop sobre as referências ativas
                        foreach ($items as $item) {
                            // Verificar se a qtd_separada está vazia, igual a zero ou menor
                            // if (!isset($item['qtd_separada']) || $item['qtd_separada'] <= 0) {
                            //    $this->emit('swal:error', ['title' => 'Erro!', 'text' => 'A quantidade separada não pode //estar vazia, igual a zero ou menor.']);
                            //      return;
                            //  }

                            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

                            if ($socket === false) {
                                $this->emit('swal:error', ['title' => 'Erro!', 'text' => "Não foi possível criar o socket: " . socket_strerror(socket_last_error())]);
                                return;
                            }

                            $result = socket_connect($socket, $ip, $port);

                            if ($result === false) {
                                socket_close($socket);
                                $this->emit('swal:error', ['title' => 'Erro!', 'text' => "Não foi possível conectar-se à impressora: " . socket_strerror(socket_last_error())]);
                                return;
                            }

                            $designacao = $checkcont->design;
                            $qtdseparada = $item['qtd_separada'];
                            $barcode = $checkcont->barcode;
                            // Dados para o código de barras
                            $barcodeData = $checkcont->barcode;

                            // Comando EPL2 com texto e código de barras
                            $epl2Command = "N\n";

                            $epl2Command .= "A125,325,0,1,1,2,N,\"$designacao\"\n"; // Designações acima do código de barras
                            $epl2Command .= "B150,355,0,1E,2,2,100,N,\"$barcodeData\"\n"; // Código de barras
                            $epl2Command .= "A225,455,0,1,1,2,N,\"$barcode\"\n"; // Código de barras numeros

                            $epl2Command .= "P$qtdseparada\n";

                            // Tente enviar o comando EPL2 para a impressora
                            $bytesSent = socket_write($socket, $epl2Command, strlen($epl2Command));
                        }

                        // Verifique se o envio foi bem-sucedido
                        if ($bytesSent === false) {
                            socket_close($socket);
                            return "Erro ao enviar comando para a impressora: " . socket_strerror(socket_last_error());
                        }

                        socket_close($socket);

                    }
                }

            }
        }
        // Emite um evento de sucesso
        $this->emit('swal:success', ['title' => 'Sucesso!', 'text' => 'Impressão enviada com sucesso dos checkbox selecionados!']);
        $this->emit('impressaoConcluida');

        $this->referenciasSelecionadas = [];
    }

    public function enviar($encomenda)
    {
        // Busca os movimentos na tabela MovimentosStock que correspondem à encomenda
        $movimentos = DB::table('movimentos_stock')
            ->where('numero_encomenda', $encomenda)
            ->get();

        // Verifica se há movimentos para enviar
        if ($movimentos->isEmpty()) {
            return redirect()->route('tenant.encomendas.encomendadetail', $encomenda)
                ->with('message', 'Não houve Pickings para serem enviados!')
                ->with('status', 'error');
        }

        $dadosMovimento["id"] = "";
        $dadosMovimento["lines"] = [];

        foreach ($movimentos as $i => $movimento) {

            $dadosMovimento["id"] = $movimento->numero_encomenda;

            $dadosMovimentostock = [
                "id" => $movimento->numero_encomenda,
                "document" => $movimento->document,
                "id_line" => $movimento->id_line,
                "referense" => $movimento->referencia,
                "barcode" => $movimento->barcode,
                "design" => $movimento->descricao,
                "quantity" => $movimento->qtd_separada,
                "internal_notes" => $movimento->internal_notes,
                "stock" => $movimento->stock,
                "warehouse" => $movimento->warehouse,
            ];

            array_push($dadosMovimento["lines"], $dadosMovimentostock);

        }

        // Converte o array em JSON
        $dadosJson = json_encode($dadosMovimento);

        // Inicia a sessão cURL
        $curl = curl_init();

        // Configura as opções da sessão cURL
        curl_setopt_array($curl, [
            CURLOPT_URL => 'http://phc.boxpt.com:443/out/out_lines',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $dadosJson,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
            ],
        ]);
        // Executa a solicitação cURL e armazena a resposta
        $response = curl_exec($curl);

        // Verifica se ocorreu algum erro durante a solicitação cURL
        if (curl_errno($curl)) {
            // Lidar com o erro adequadamente, por exemplo, registrando-o ou lançando uma exceção
            $error_message = curl_error($curl);
            // Faça o que for necessário com o erro
            return redirect()->route('tenant.encomendas.encomendadetail', $encomenda)
                ->with('message', 'Erro ao enviar!' . $error_message)
                ->with('status', 'error');
        }

        // Fecha a sessão cURL
        curl_close($curl);
        // Exclui os registros da tabela MovimentosStock correspondentes à encomenda enviada
        DB::table('movimentos_stock')
            ->where('numero_encomenda', $encomenda)
            ->delete();

        return redirect()->route('tenant.dashboard', $encomenda)
            ->with('message', 'Pickings enviados com sucesso!')
            ->with('status', 'success');
    }

    public function render()
    {

        $this->encomendaSpecific = $this->encomendaRepository->detalhesCodBarras($this->encomenda, $this->perPage);
        //$this->encomendaSpecific = $this->encomendaRepository->encomendaMovimentos($this->stringEncomenda,$this->perPage);

        return view('tenant.livewire.encomendas.encomendadetail', ["encomendaDetail" => $this->encomendaSpecific, "idEncomenda" => $this->encomenda]);

    }
}
