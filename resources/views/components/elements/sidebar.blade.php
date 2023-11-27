<div class="deznav">
    <div class="deznav-scroll">
        {{-- @if (Auth::user()->type_user != '2')
            <a href="{{ route('tenant.tasks.create') }}" class="add-menu-sidebar">{{ __('New Task') }}</a>
        @endif --}}
        <ul class="metismenu" id="menu">
            <li><a class="ai-icon" href="{{ route('tenant.dashboard') }}">
                    <i class="flaticon-381-networking" style="color:#326c91;"></i>
                    <span class="nav-text">{{ __('Dashboard') }}</span>
                </a>
            </li>
      
            @if (Auth::user()->type_user == '0')

                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="fa-solid fa-truck"></i>
                    <span class="nav-text">Scan Encomendas</span>
                    </a>
                    <ul aria-expanded="false">
                       <li><a href="{{ route('tenant.encomendas.rececao') }}">{{ __('Documents') }}</a></li>
                    </ul>
                </li>

                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="fa-solid fa-dolly"></i>
                    <span class="nav-text">Arrumações</span>
                    </a>
                    <ul aria-expanded="false">
                       <li><a href="{{ route('tenant.arrumacoes.index') }}">{{ __('Arrumações') }}</a></li>
                    </ul>
                </li>

                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="fa-solid fa-right-left"></i>
                    <span class="nav-text">Devoluções</span>
                    </a>
                    <ul aria-expanded="false">
                       <li><a href="{{ route('tenant.devolucoes.index') }}">{{ __('Devoluções') }}</a></li>
                    </ul>
                </li>

                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="fa-solid fa-people-carry-box"></i>
                    <span class="nav-text">Separar Encomendas</span>
                    </a>
                    <ul aria-expanded="false">
                       <li><a href="{{ route('tenant.separacoes.index') }}">{{ __('Separação') }}</a></li>
                    </ul>
                </li>

                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="fa-solid fa-boxes-stacked"></i>
                    <span class="nav-text">Transferências</span>
                    </a>
                    
                    <ul aria-expanded="false">
                       <li><a href="{{ route('tenant.transferencia.index') }}">{{ __('Transferir') }}</a></li>
                       <li><a href="{{ route('tenant.listagem.index')}}">{{ __('Listagem') }}</a></li>
                    </ul>
                </li>

                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-gear"></i>
                        <span class="nav-text">{{ __('Setup') }}</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('tenant.setup.app') }}">{{ __('Config')}}</a></li>
                        <li><a href="{{ route('tenant.codbarras-produto.index')}}">Atualizar Código de Barras de produto</a></li>
                        <li><a href="{{ route('tenant.codbarras-localizacao.index')}}">Atualizar Código de Barras de localização</a></li>
                        <li><a href="{{ route('tenant.locations.index') }}">Localizações</a></li>
                        <li><a href="{{ route('tenant.locations.order') }}">Ordem Localizações</a></li>
                    </ul>
                </li>
            @endif

        </ul>
        <div class="copyright">
            @php
                $config_user = \App\Models\Tenant\Config::first();
            @endphp
            <small><strong>{{ $config_user->company_name }}</strong></small>
            <p>© {{ date('Y') }} {{ __('All Rights Reserved') }}</p>
        </div>
    </div>
</div>
