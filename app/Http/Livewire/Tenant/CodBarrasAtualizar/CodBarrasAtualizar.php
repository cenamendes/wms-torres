<?php

namespace App\Http\Livewire\Tenant\CodBarrasAtualizar;

use App\Interfaces\Tenant\CodBarrasAtualizar\CodBarrasAtualizarInterface;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Tenant\Customers;
use App\Models\Tenant\Encomendas;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Tenant\RececaoObservacoes;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Interfaces\Tenant\Localizacoes\LocalizacoesInterface;

class CodBarrasAtualizar extends Component
{

    // protected $listeners = ["ReceiveImage" => "ReceiveImage"];
        
    public string $codbarras = '';
    public string $descricao = '';
    public string $newcodbarras = '';

    // private ?object $localizacoes = NULL;

    protected object $codbarrasRepository;
    
    public function boot(CodBarrasAtualizarInterface $interfaceCodBarras)
    {
        $this->codbarrasRepository = $interfaceCodBarras;
    }

    public function mount()
    {
     
        //$this->localizacoes = $this->codbarrasRepository->getLocalizacoes($this->perPage);

    }

    public function updatedCodbarras()
    {
        if($this->codbarras != null)
        {
            $result = $this->codbarrasRepository->getCodBarrasInformation($this->codbarras);
        }

        if(isset($result))
        {
            if($result->reference == null){

                $this->dispatchBrowserEvent('swalFire', ['title' => "Scan Código de Barras", 'message' => "Esse código de barras não existe.", 'status' => 'error']);
            } else {

                $this->descricao = $result->description;
            }

        }


    }

    public function guardaStock()
    {
        if($this->codbarras != "" && $this->newcodbarras != ""){
           $result = $this->codbarrasRepository->changeCodBarrasProduct($this->codbarras,$this->newcodbarras);

           if($result->success == "true")
           {
                $this->codbarras = "";
                $this->descricao = "";
                $this->newcodbarras = "";

                $this->dispatchBrowserEvent('swalFire', ['title' => "Alteração Código", 'message' => "Código de barras alterado com sucesso.", 'status' => 'success']);

           }
            
        } else {
            $this->dispatchBrowserEvent('swalFire', ['title' => "Código de Barras", 'message' => "Necessita de preencher os dois campos de código de barras.", 'status' => 'error']);
        }
       
    }


    public function render()
    {   
        
        // **  Numero de encomendas de fornecedor abertos  **/

        // if(isset($this->searchString) && $this->searchString) {
        //     $this->localizacoes = $this->localizacoesRepository->getLocalizacoesSearch($this->searchString,$this->perPage);
        // } else {
        //     $this->localizacoes = $this->localizacoesRepository->getLocalizacoes($this->perPage);
        // }


        
        return view('tenant.livewire.codbarrasatualizar.index');
    }
}
