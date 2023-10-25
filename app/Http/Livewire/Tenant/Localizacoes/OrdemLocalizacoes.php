<?php

namespace App\Http\Livewire\Tenant\Localizacoes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Interfaces\Tenant\Lacagem\LacagemInterface;
use App\Models\Tenant\Localizacoes;

class OrdemLocalizacoes extends Component
{
    use WithPagination;

    public $iteration = 0;
    
    protected $listeners = ["sendChangesPlanning" => 'sendChangesPlanning', "createNestableByOrder" => "createNestableByOrder"];
  
    private ?object $documents = NULL;

    public string $message = '';
  
    protected object $lacagemRepository;

    // public function boot(LacagemInterface $lacagemInterface)
    // {
    //     $this->lacagemRepository = $lacagemInterface;
    // }

    public function mount()
    {
        $this->documents = Localizacoes::all();
        $this->message = '';
    }

    public function refreshPlanning()
    {
        $this->dispatchBrowserEvent('planning');
        $this->skipRender();
    }

    public function createNestableByOrder()
    {
        $this->documents = Localizacoes::all();
        $this->message = '';

        $this->message = "<div class='nestable'>";
        $this->message .= "<div class='dd' id='nestable' wire:ignore>";
        $this->message .= "<ol class='dd-list' data-type='grouplist'>";
        foreach($this->documents as $id => $plan)
        {
            $this->message .= "<li class='dd-item' data-id='".$id."' data-type='group'>";
            $this->message .= "<div class='dd-handle' style='font-size:18px;font-weight:500;'>";
            $this->message .= " <input type='hidden' class='abreviatura' value=".$plan->abreviatura.">";

            $this->message .= "".$plan->abreviatura; 

            $this->message .= "</div>";
            $this->message .= "</li>";
        }

        $this->message .= "</ol>";
        $this->message .= "</div>";
        $this->message .= "</div>";

        $this->dispatchBrowserEvent('contentChanged');

    }


    /********************** */

    public function sendChangesPlanning($arrayChangesPlanning)
    {
       $count = 1;
       foreach($arrayChangesPlanning as $changes)
       {
          Localizacoes::where('abreviatura',$changes['abreviatura'])->update([
            "ordem" => $count
          ]);

          $count++;
       }
       
       //$this->skipRender();
       $this->createNestableByOrder();

    }

    public function originalOrder()
    {
        $this->documents = Localizacoes::all();
        $this->createNestableByOrder();
    }

    public function render()
    {
        return view('tenant.livewire.localizacoes.ordem',["planeamento" => $this->documents,'message' => $this->message,'iteration' => $this->iteration]);
    }
}
