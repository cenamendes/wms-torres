   <link rel="icon" type="image/png" sizes="16x16" href="{{ 'assets/resources/images/logo_png_boxpt.png' }}">
   <style>
       .main {
           width: 100%;
           height: auto;
           background: #F4F6FA;
       }

       .links {
           display: flex;
           gap: 1rem;
           flex-direction: column;
           padding: 1rem;
           margin: 2rem;
           background: #ffffff;
           box-shadow: 0px 0px 15px 1px rgb(209, 209, 209);
       }

       .links-entrada {
           padding: 1rem;
       }

       .button {
           font-size: 1rem;
           border: 1px rgb(75, 75, 75) solid;
           padding: 6px 10px;
           width: 18rem;
           background-color: #f5f5f5;
           font-weight: 600;
       }

       .button:hover {
           color: black;
           background-color: #ffffff;
       }

       h2 {
           padding-top: 1rem;
           padding-left: 2rem;
           font-weight: 600;
           font-size: 1.5rem;
           color: black;
       }

       .sk-child.sk-bounce1,
       .sk-child.sk-bounce2,
       .sk-child.sk-bounce3 {
           background: #0d0d0d;
       }

       .dataTables_wrapper .dataTables_paginate .paginate_button.previous,
       .dataTables_wrapper .dataTables_paginate .paginate_button.next {
           background: #0d0d0d !important;
           color: #fff !important;
           border: 0px solid #0d0d0d !important;
       }

       .dataTables_wrapper .dataTables_paginate .paginate_button:hover,
       .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover,
       .dataTables_wrapper .dataTables_paginate .paginate_button.current {
           color: #fff !important;
           background: #0d0d0d !important;
       }

       .dataTables_wrapper .dataTables_paginate .paginate_button {
           border: 0 !important;
           background: transparent !important;
           color: #0d0d0d !important;
       }

       @media only screen and (max-width: 520px) {
           .links {
               display: flex;
               gap: 1rem;
               flex-direction: column;
               padding: 1rem 0.6rem;
               margin: 1rem;
               background: #ffffff;
               box-shadow: 0px 0px 15px 1px rgb(209, 209, 209);
           }

           .button {
               font-size: 0.78rem;
               border: 1px rgb(75, 75, 75) solid;
           }

           h2 {
               padding-top: 1.2rem;
               padding-left: 1rem;
               font-size: 1.2rem;
           }
       }
   </style>
   <main class="main">
       <h2>Entrada:</h2>
       <div class="links">
           <div class="links-entrada">
               <a class="button" href="{{ route('tenant.dashboard') }}">Compras a Fornecedor</a>
           </div>
           <div class="links-entrada">
               <a class="button" href="{{ route('tenant.devolucoesclientes') }}">Devoluções de Clientes</a>
           </div>
           <div class="links-entrada">
               <a class="button" href="{{ route('tenant.devolucoesmaterialdanificado') }}">Devoluções Material
                   Danificado</a>
           </div>
       </div>
       <h2>Transferência de Stock:</h2>
       <div class="links">
           <div class="links-entrada">
               <a class="button" href="{{ route('tenant.transferencias.transferencia') }}">Transferências</a>
           </div>
           <div class="links-entrada">
               <a class="button" href="{{ route('tenant.transferencias.listagemdetail') }}">Listagem</a>
           </div>
       </div>
       <h2>Análises:</h2>
       <div class="links">
           <div class="links-entrada">
               <a class="button" href="{{ route('tenant.analises.picking') }}">Picking</a>
           </div>
           <div class="links-entrada">
               <a class="button" href="{{ route('tenant.analises.reportadosatualizados') }}">Reportados Atualizados</a>
           </div>
       </div>
       @if (Auth::user()->type_user == '0' || Auth::user()->type_user == '2')
       <h2>Gestão de Stock:</h2>
       <div class="links">

               <div class="links-entrada">
                   <a class="button" href="{{ route('tenant.gestaostock.reportados') }}">Reportados</a>
               </div>
               <div class="links-entrada">
                   <a class="button" href="{{ route('tenant.stock.stock') }}">Stock</a>
               </div>
       </div>
       @endif
       <h2>Saída:</h2>
       @if (property_exists($saidas, 'types'))
           <div class="links">
               @foreach ($saidas->types as $type)
                   <div class="links-entrada">
                       <a class="button" href="{{ route('tenant.saida', ['idsaida' => $type->Id]) }}">
                           <span>{{ $type->Name }}</span>
                       </a>
                   </div>
               @endforeach
           </div>
       @else
           <p>Faça Refresh.</p>
       @endif

       @if (Auth::user()->type_user == '0' || Auth::user()->type_user == '2')
           <h2>Administração:</h2>
           <div class="links">
               <div class="links-entrada">
                   <a class="button" href="{{ route('tenant.administracao.adm') }}">{{ __('Gestão') }}</a></li>
               </div>
           </div>
       @endif

       @if (Auth::user()->type_user == '0')
           <h2>Configurações:</h2>
           <div class="links">
               <div class="links-entrada">
                   <a class="button" href="{{ route('tenant.setup.app') }}">{{ __('Config') }}</a>
               </div>
           </div>
       @endif
   </main>
