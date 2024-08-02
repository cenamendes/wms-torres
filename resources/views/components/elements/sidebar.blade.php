<style>
    #icon {
        color: #131212;
    }

    .nav-text {
        color: rgb(102, 102, 102);
    }

    [data-sidebar-style="full"][data-layout="vertical"] .deznav .metismenu>li>a:before {
        background: #131212;
        /* Cor original */
    }

    [data-sidebar-style="full"][data-layout="vertical"] .menu-toggle .deznav .metismenu>li.mm-active>a {
        background: #c8c8c8;
        /* Nova cor desejada */
    }


    [data-sidebar-style="full"][data-layout="vertical"] .deznav .metismenu>li.mm-active>a {
        color: #000000;
    }

    [data-sidebar-style="full"][data-layout="vertical"] .deznav .metismenu>li.mm-active>a:hover {
        color: #000000;
    }

    .deznav .metismenu ul a:hover,
    .deznav .metismenu ul a:focus,
    .deznav .metismenu ul a.mm-active {
        text-decoration: none;
        color: #0c0c0c;
    }

    @media only screen and (min-width: 768px) {
        [data-sidebar-style="mini"][data-layout="vertical"] .deznav .metismenu>li.mm-active>a {
            background: #c8c8c8;
            color: #fff;
            border-radius: 1.25rem;
        }

        [data-sidebar-style="mini"][data-layout="vertical"] .deznav .metismenu>li:nth-last-child(-n + 1)>ul {
            bottom: -100px;
            top: auto;
        }

        .deznav .metismenu>li.mm-active>a.has-arrow.ai-icon {
            color: #000000;
        }
        .deznav .metismenu > li.mm-active > a {
    color: #000000;
}

    }
</style>
<div class="deznav">
    <div class="deznav-scroll">
        {{-- @if (Auth::user()->type_user != '2')
            <a href="{{ route('tenant.tasks.create') }}" class="add-menu-sidebar">{{ __('New Task') }}</a>
        @endif --}}
        <ul class="metismenu" id="menu">
            <li>
                <a href="{{ route('tenant.entrada') }}">
                    <i id="icon" class="fas fa-home"></i>
                    <span class="nav-text">Home</span>
                </a>
            </li>
            <li>
                <a class="has-arrow ai-icon" aria-expanded="false" href="javascript:void()">
                    <i id="icon" class="flaticon-381-networking"></i>
                    <span class="nav-text">{{ __('Dashboard') }}</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('tenant.dashboard') }}">{{ __('Compras a Fornecedor') }}</a></li>
                    <li><a href="{{ route('tenant.devolucoesclientes') }}">{{ __('Devoluções de Clientes') }}</a></li>
                    <li><a
                            href="{{ route('tenant.devolucoesmaterialdanificado') }}">{{ __('Devoluções Material Danificado') }}</a>
                    </li>
                </ul>
            </li>


            <li>
                <a class="has-arrow ai-icon" aria-expanded="false" href="javascript:void()">
                    <i id="icon" class="fas fa-cubes"></i>
                    <span class="nav-text">Transferência Stock</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('tenant.transferencias.transferencia') }}">{{ __('Transferencias') }}</a></li>
                    <li><a href="{{ route('tenant.transferencias.listagemdetail') }}">{{ __('Listagem') }}</a></li>
                </ul>
            </li>

            <li>
                <a class="has-arrow ai-icon" aria-expanded="false" href="javascript:void()">
                    <i id="icon" class="fas fa-chart-bar"></i>
                    <span class="nav-text">Análises</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('tenant.analises.picking') }}">{{ __('Picking') }}</a></li>
                    <li><a
                            href="{{ route('tenant.analises.reportadosatualizados') }}">{{ __('Reportados Atualizados') }}</a>
                    </li>
                </ul>
            </li>

            @if (Auth::user()->type_user == '0' || Auth::user()->type_user == '2')
            <li>
                <a class="has-arrow ai-icon" aria-expanded="false" href="javascript:void()">
                    <i id="icon" class="fas fa-database"></i>
                    <span class="nav-text">Gestão de Stock</span>
                </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('tenant.gestaostock.reportados') }}">{{ __('Reportados') }}</a></li>
                        <li><a href="{{ route('tenant.stock.stock') }}">{{ __('Stock') }}</a></li>
                    </ul>
                @endif
            </li>

            <li>
                <a class="has-arrow ai-icon" aria-expanded="false" href="javascript:void()">
                    <i id="icon" class="fas fa-arrow-alt-circle-right"></i>
                    <span class="nav-text">Saídas</span>
                </a>
                <ul aria-expanded="false">
                    @livewire('tenant.sidebar.sidebar')
                </ul>
            </li>

            @if (Auth::user()->type_user == '0' || Auth::user()->type_user == '2')
                <li>
                    <a class="has-arrow ai-icon" aria-expanded="false" href="javascript:void()">
                        <i id="icon" class="fas fa-users-cog"></i>
                        <span class="nav-text">Administração</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('tenant.administracao.adm') }}">{{ __('Gestão') }}</a></li>
                    </ul>
                </li>
            @endif

            @if (Auth::user()->type_user == '0')
                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i id="icon" class="fa-solid fa-gear"></i>
                        <span class="nav-text">{{ __('Setup') }}</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('tenant.setup.app') }}">{{ __('Config') }}</a></li>
                        <!--
                        <li><a href="{{ route('tenant.codbarras-produto.index') }}">Atualizar Código de Barras de produto</a></li>
                        <li><a href="{{ route('tenant.codbarras-localizacao.index') }}">Atualizar Código de Barras de localização</a></li>
                        <li><a href="{{ route('tenant.locations.index') }}">Localizações</a></li>
                        <li><a href="{{ route('tenant.locations.order') }}">Ordem Localizações</a></li> -->
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
