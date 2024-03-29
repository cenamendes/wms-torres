<div>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <div class="table-responsive" wire:key="tenantcustomersshow">
      <div id="ajaxLoading" wire:loading.flex class="w-100 h-100 flex "
          style="background:rgba(255, 255, 255, 0.8);z-index:999;position:fixed;top:0;left:0;align-items: center;justify-content: center;">
          <div class="sk-three-bounce" style="background:none;">
              <div class="sk-child sk-bounce1"></div>
              <div class="sk-child sk-bounce2"></div>
              <div class="sk-child sk-bounce3"></div>
          </div>
      </div>
    
      <div class="container-fluid">
        <div class="row">
            <div class="col-xl-9 col-xs-6">
                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Separações</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('List') }}</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                        <div class="card-header">
                            <div class="col-xs-6 col-md-12" style="padding-left:0px;">
                                <h4 class="card-title">{{ __('Separações') }}</h4>
                            </div>
                            <div class="col-xs-6 col-md-3">
                               
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="dataTables_wrapper" class="dataTables_wrapper">
                                <div class="dataTables_length" id="dataTables_length">
                                    <label>{{ __('Show') }}
                                        <select name="perPage" aria-controls="select" wire:model="perPage">
                                            <option value="10"
                                                @if ($perPage == 10) selected @endif>10</option>
                                            <option value="25"
                                                @if ($perPage == 25) selected @endif>25</option>
                                            <option value="50"
                                                @if ($perPage == 50) selected @endif>50</option>
                                            <option value="100"
                                                @if ($perPage == 100) selected @endif>100</option>
                                        </select>
                                        {{ __('entries') }}</label>
                                </div>
                                <div id="dataTables_search_filter" class="dataTables_filter">
                                    <label>Procurar número de encomenda:
                                        <input type="search" name="searchString" wire:model="searchString"></label>
                                </div>
                            </div>
                            
                            <!-- display dataTable no-footer -->
                            {{-- <div> --}}
                                <table class="table-striped" style="width:100%;table-layout:fixed;">
                                    <thead>
                                        <tr style="text-align:center;">
                                            <th style="padding-bottom: 10px;">Número de Encomenda</th>
                                            <th style="padding-bottom: 10px;">Nome do Fornecedor</th>
                                            <th style="padding-bottom: 10px;">Data do Documento</th>
                                            <th style="padding-bottom: 10px;">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($encomendas as $impr)
                                            <tr style="text-align:center;">
                                                <td style="padding-bottom:30px;"><br><span>{{ $impr->order_number }}</span></td>
                                                <td><span style="padding-right: 5px;padding-left: 5px;">{{ $impr->costumer_name }}</span></td>
                                                <td><span style="padding-right: 5px;padding-left: 5px;">{{ date('Y-m-d',strtotime($impr->order_date)) }}</span></td>
                                                <td>
                                                    <a href="{{ route('tenant.separacoes.encomenda.detail', trim($impr->stamp)) }}" class="btn btn-primary shadow sharp mr-1">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                        
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $encomendas->links() }}
                            {{-- </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    </div>