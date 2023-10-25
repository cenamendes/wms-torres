<div>
    <div id="ajaxLoading" wire:loading.flex class="w-100 h-100 flex "
        style="background:rgba(255, 255, 255, 0.8);z-index:999;position:fixed;top:0;left:0;align-items: center;justify-content: center;">
        <div class="sk-three-bounce" style="background:none;">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ $homePanel }}" data-toggle="tab" href="#homePanel">
                <i class="fa fa-house" aria-hidden="true"></i> {{ __('Company') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $pickPanel }}" data-toggle="tab" href="#pickPanel">
                <i class="fa fa-user" aria-hidden="true"></i> {{ __('Modo de Pickagem') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade {{ $homePanel }}" id="homePanel" role="tabpanel">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-0" style="border-top-left-radius: 0px; border-top-right-radius: 0px;">
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="row">
                                    <div class="col">
                                        <div class="row form-group">
                                            <section class="col">
                                                <label for="company_name">{{ __('Company Name') }}</label>
                                                <input type="text" name="company_name" id="company_name" class="form-control"
                                                value="@if(isset($config->company_name)) $config->company_name @endif" wire:model.lazy="company_name">
                                            </section>
                                        </div>
                                        <div class="row form-group">
                                            <section class="col-3">
                                                <label for="vat">{{ __('VAT') }}</label>
                                                <input type="text" name="vat" id="vat" class="form-control"
                                                value="@if(isset($config->vat)) $config->vat @endif" wire:model.lazy="vat">
                                            </section>
                                            <section class="col-3">
                                                <label for="contact">{{ __('Phone number') }}</label>
                                                <input type="text" name="contact" id="contact" class="form-control"
                                                value="@if(isset($config->contact)) $config->contact @endif" wire:model.lazy="contact">
                                            </section>
                                            <section class="col-6">
                                                <label for="email">{{ __('Primary e-mail address') }}</label>
                                                <input type="text" name="email" id="email" class="form-control"
                                                value="@if(isset($config->email)) $config->email @endif" wire:model.lazy="email">
                                            </section>
                                        </div>
                                        <div class="row form-group">
                                            <section class="col-12">
                                                <label for="address">{{ __('Address') }}</label>
                                                <textarea rows="4" type="text" name="address" id="address" class="form-control"  wire:model.lazy="address">@if(isset($config->address)) $config->address @endif</textarea>
                                            </section>
                                        </div>
                                        <div class="row ">
                                            <section class="col-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button class="btn btn-primary btn-sm" type="button">{{__("Image")}}</button>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" name="uploadFile" id="uploadFile" class="custom-file-input" wire:model="uploadFile">
                                                        <label class="custom-file-label">@if(isset($image)) {{$image}} @else {{__('Choose file')}} @endif</label>
                                                    </div>
                                                </div>
                                            </section>
                                            <section class="col-6">
                                                @if ($uploadFile)
                                                    <img src="{{ $uploadFile->temporaryUrl() }}" style="max-width:300px;">
                                                @elseif (isset($logotipo) && $logotipo)
                                                    <img src="{{ global_tenancy_asset('/app/public/images/logo/' . $logotipo) }}" style="max-width:300px;">
                                                @endif
                                            </section>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade {{ $pickPanel }}" id="pickPanel" role="tabpanel">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-0" style="border-top-left-radius: 0px; border-top-right-radius: 0px;">
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="row">
                                    <div class="col">
                                        <div class="row form-group">
                                            <section class="col-6">
                                                <label>{{ __('Verificações:') }}</label>
                                                <br>
                                                <input type="checkbox" name="cod_barras_pick" id="cod_barras_pick"
                                                @if(isset($config->cod_barras_accept)) @if($config->cod_barras_accept == "1") checked @endif @endif wire:model.defer="cod_barras_pick">
                                                <label> {{ __('Código de barras') }}</label>
                                                <br>
                                                <input type="checkbox" name="reference_pick" id="reference_pick"
                                                @if(isset($config->cod_barras_accept)) @if($config->cod_barras_accept == "1") checked @endif @endif wire:model.defer="reference_pick">
                                                <label for="senderName"> {{ __('Referência') }}</label>
                                            </section>
                                            
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-footer justify-content-between">
            <div class="row">
                <div class="col text-right">
                    <a wire:click="saveTask" class="btn btn-primary">
                        {{ $actionButton }}
                        <span class="btn-icon-right"><i class="las la-check mr-2"></i></span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('custom-scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            restartObjects();
            jQuery("#alert_email").val("");
        });

        function restartObjects() {
            jQuery(document).ready(function() {
                var HelloButton = function (context) {
                    var ui = $.summernote.ui;

                    // create button
                    var button = ui.button({
                        contents: '<i class="fa fa-compress"/> Small',
                        tooltip: 'hello',
                        click: function () {
                            context.invoke('editor.pasteHTML', '<small>...</small>');
                        }
                    });

                    return button.render();   // return button as jquery object
                }

                jQuery(".summernote").summernote({
                    height: 190,
                    minHeight: null,
                    maxHeight: null,
                    focus: !1,
                    codeviewFilter: false,
                    codeviewIframeFilter: true,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['mybutton', ['hello']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                    ],
                    buttons: {
                        hello: HelloButton
                    },
                    fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana'],
                    addDefaultFonts: false,
                    callbacks: {
                        onChange: function(contents) {
                            @this.set('signature', contents, true);
                            console.log(contents)
                        }
                    },
                }), $(".inline-editor").summernote({
                    airMode: !0
                });


            });
        }
    </script>
    @endpush
</div>
