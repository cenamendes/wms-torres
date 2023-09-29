<?php

namespace App\Http\Livewire\Tenant\Dashboard;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Tenant\Files;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Tenant\Files\FilesInterface;
use App\Interfaces\Tenant\Tasks\TasksInterface;
use App\Interfaces\Tenant\TeamMember\TeamMemberInterface;
use App\Interfaces\Tenant\BudgetRequest\BudgetRequestInterface;
use App\Interfaces\Tenant\SupplierDocuments\SupplierDocumentsInterface;
use App\Interfaces\Tenant\CustomersDocuments\CustomersDocumentsInterface;
use App\Interfaces\Tenant\CustomerNotification\CustomerNotificationInterface;

class Show extends Component
{
    use WithPagination;
    
    public int $perPage;
    public int $perPage2;
    public string $searchString = '';
    public string $searchString2 = '';


    public function boot()
    {

    }

    public function mount()
    {
    //    $this->dashboardUpdate();

        if (isset($this->perPage)) {
            session()->put('perPage', $this->perPage);
        } elseif (session('perPage')) {
            $this->perPage = session('perPage');
        } else {
            $this->perPage = 10;
        }
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

   
    public function paginationView()
    {
        return 'tenant.livewire.setup.pagination';
    }

    public function dashboardUpdate()
    {

        if (isset($this->perPage)) {
            session()->put('perPage', $this->perPage);
        } elseif (session('perPage')) {
            $this->perPage = session('perPage');
        } else {
            $this->perPage = 10;
        }

    }

    
    public function render()
    {

        return view('tenant.livewire.dashboard.show');
    }
}
