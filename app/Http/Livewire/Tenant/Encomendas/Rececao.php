<?php

namespace App\Http\Livewire\Tenant\Encomendas;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Tenant\Customers;
use App\Models\Tenant\Encomendas;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Tenant\RececaoObservacoes;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;

class Rececao extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $listeners = ["ReceiveImage" => "ReceiveImage"];
    
    public int $perPage;
    
    public string $searchString = '';

    private ?object $encomendas = NULL;

    public $image;

    protected object $encomendaRepository;
    
    public function boot(EncomendasInterface $interfaceEncomenda)
    {
        $this->encomendaRepository = $interfaceEncomenda;
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

        $this->encomendas = $this->encomendaRepository->getEncomendas($this->perPage);
    }

    public function downloadFileRececao($id)
    {
        $enc = Encomendas::where('id',$id)->first();

        return response()->download(public_path().'/cl/'.$enc->imagem);
    }


    public function ReceiveImage($imageReceived)
    {
        $array_encomenda = [];


        /*****PARTE DO SCAN ********/

        if (preg_match('/^data:image\/(\w+);base64,/', $imageReceived)) {
            $data = substr($imageReceived, strpos($imageReceived, ',') + 1);
        
            $data = base64_decode($data);
        }

        if(!Storage::exists(tenant('id') . '/app/scans'))
        {
            File::makeDirectory(storage_path('app/scans'), 0755, true, true);
        }

        $random = rand('1000000000','9999999999');
        Storage::put(tenant('id') . '/app/scans/'.$random.'.png', $data);

        $imagem_link = tenant('id') . '/app/scans/'.$random.'.png';


        /**************************** */
        

        /***********PARTE DO OCR VERYFI**********/

         
        // $cFile = global_tenancy_asset('/app/scans/'.$random.'.png');

        // $curl = curl_init();

        // curl_setopt_array($curl, [
        // CURLOPT_URL => "https://api.veryfi.com/api/v8/partner/documents",
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => "",
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 30,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        // CURLOPT_CUSTOMREQUEST => "POST",
        // CURLOPT_POSTFIELDS => json_encode([
        //     'file_url' => $cFile,
        //     'auto_delete' => null
        // ]),
        // CURLOPT_HTTPHEADER => [
        //     "Accept: application/json",
        //     "CLIENT-ID: vrfXDkDBXA0AYFd4NC4aakvODTzAupvSpCk2uXD",
        //     "Content-Type: application/json",
        //     "AUTHORIZATION: apikey joaomendesgpro:9e80d707af2e6f1dbf32ec4c121c075e"
        // ],
        // ]);

        // $response = curl_exec($curl);

        // curl_close($curl);


        //FICHEIRO DA BRVR
        //$response = '{"account_number": "976", "bill_to": {"address": "Rua de Regufe, n. 33\n4480-246 Vila do Conde\nVila do Conde", "name": null, "parsed_address": null, "vat_number": "505781417"}, "cashback": null, "category": "Payroll Expenses", "created_date": "2023-09-27 15:08:03", "currency_code": "EUR", "date": "2023-09-22 00:00:00", "delivery_date": null, "discount": null, "document_reference_number": null, "document_title": null, "document_type": "invoice", "due_date": null, "duplicate_of": null, "external_id": null, "id": 158410905, "img_file_name": "158410905.jpg", "img_thumbnail_url": "https://scdn.veryfi.com/receipts/2734e8bc88daecc3/72382b7b-5059-4d75-8ce1-a8ecc63875d4/thumbnail.jpg?Expires=1695828184&Signature=EJapER0QZoJ9MjcDJ2G9pnPZ1v01GtvqHnLbNzRbsZdHo1DQJ7ywD8MkktBbq5fLEYiRVs3jI~K0BcabtDS5si4SqOEV2NH-l3pDgSpTanQ5J7YJ75zCYeA2KxZ3u-jBsdLkl1aruf6g5LdHpVY6e5abY6ezKP6wxGpV1ssXC9CEji8NRvxwcchRJOC~Rw8ENfnSbKT6O68-Gwm0ILVYiSgIuBfoAoYPrJe4bEiAKMp4J34vzLYJGRV3VFsB86wFS~WmUyI2CaTMvw-sO7UMATbcLpJmyeMARR88~CBLf8JRf5-tjQvUwxHbesmcXpMcm-hs8PZhJjRVYGOUlATCmQ__&Key-Pair-Id=APKAJCILBXEJFZF4DCHQ", "img_url": "https://scdn.veryfi.com/receipts/2734e8bc88daecc3/72382b7b-5059-4d75-8ce1-a8ecc63875d4/071f688e-2670-4610-8e85-8708df2d62d4.jpg?Expires=1695828184&Signature=cPshzBrOnMXwdzixDin3jR6s7IFOLyDE4tsje9tq6Cssf9dg24fVFam3GHifv72vS8iZx~NZwvBwGjnNLbVl2aM3t3IwXaHxkYFH~sHN9v1JxUM18Xk0Jif723LqWyXHjLQ3CAlq2omYzdRmWqG48tXV-yw2wrs9vJ6OQuhJVbbjXB0dsM7SN34zpStCpSRxqPZSnLNI~leTis4G9BPv-NFD7uWqDCrZOZNmP1Re61uv3zxjz8s-ULWxHMI3qD5lGzmMh-6t2hgeRNA5jjB9XhrEMwkGmWcKql9HSIFcTczDotgC9wgvVCQOlIqoWZYQRIu-FsfpxYpa~4OnwCEa~A__&Key-Pair-Id=APKAJCILBXEJFZF4DCHQ", "insurance": null, "invoice_number": null, "is_duplicate": false, "is_money_in": false, "line_items": [{"date": null, "description": "TONOKI4446 Toner OKI C510/C511/C530/C531/MC561/MC562 Yellow (5K)\n1,0\nUni", "discount": null, "discount_rate": null, "end_date": null, "id": 688555337, "order": 0, "price": null, "quantity": 1.0, "reference": null, "section": null, "sku": null, "start_date": null, "tags": [], "tax": null, "tax_rate": null, "text": "TONOKI4446 Toner OKI C510/C511/C530/C531/MC561/MC562 Yellow (5K)\t1,0 Uni", "total": null, "type": "product", "unit_of_measure": null, "upc": null}, {"date": null, "description": "TONOKI4446 Toner OKI C510/C511/C530/C531/MC561/MC562 Magenta (5K)\n1,0\nUni", "discount": null, "discount_rate": null, "end_date": null, "id": 688555338, "order": 1, "price": null, "quantity": 1.0, "reference": null, "section": null, "sku": null, "start_date": null, "tags": [], "tax": null, "tax_rate": null, "text": "TONOKI4446 Toner OKI C510/C511/C530/C531/MC561/MC562\tMagenta (5K)\t1,0 Uni", "total": null, "type": "product", "unit_of_measure": null, "upc": null}, {"date": null, "description": "TONOKI4446 Toner OKI C510/C511/C530/C531/MC561/MC562 Cyan (5K)\n1.0\nUni", "discount": null, "discount_rate": null, "end_date": null, "id": 688555339, "order": 2, "price": null, "quantity": 1.0, "reference": null, "section": null, "sku": null, "start_date": null, "tags": [], "tax": null, "tax_rate": null, "text": "TONOKI4446 Toner OKI C510/C511/C530/C531/MC561/MC562\tCyan (5K)\t1.0 Uni", "total": null, "type": "product", "unit_of_measure": null, "upc": null}, {"date": null, "description": "TONOKI4497 Toner OKI C511/C531/MC562 Preto (7K)\n1,0\nUni", "discount": null, "discount_rate": null, "end_date": null, "id": 688555340, "order": 3, "price": null, "quantity": 1.0, "reference": null, "section": null, "sku": null, "start_date": null, "tags": [], "tax": null, "tax_rate": null, "text": "TONOKI4497 Toner OKI C511/C531/MC562 Preto (7K)\t\t1,0 Uni", "total": null, "type": "product", "unit_of_measure": null, "upc": null}, {"date": null, "description": "Toner HP 44A Preto - LaserJet Pro M15/28\n1,0\nUni", "discount": null, "discount_rate": null, "end_date": null, "id": 688555341, "order": 4, "price": null, "quantity": 1.0, "reference": null, "section": null, "sku": "CF244A", "start_date": null, "tags": [], "tax": null, "tax_rate": null, "text": "CF244A\tToner HP 44A Preto - LaserJet Pro M15/28\t\t1,0 Uni", "total": null, "type": "product", "unit_of_measure": null, "upc": null}], "meta": {"owner": "joaomendesgpro", "processed_pages": 1, "source": "api", "total_pages": 1}, "notes": null, "ocr_text": "brvr\nINFORMÁTICA\nE IDENTIFICAÇÃO\nBR & VR - Identificação Informática e Serviços, Lda\t\tAGENCIA FUNERÁRIA POVEIRA LDA\nRua de Regufe, n. 33\t\t\t\t\tRUA ANTÓNIO GRAÇA, N°131 R/C\n4480-246 Vila do Conde\n\tPovoa de Varzim\nVila do Conde\n\t4490-471 Póvoa de Varzim\nTel./Fax: 252 646 260\nEmail geral@brvr.pt.\t\t\t\t\t\tEncomenda de Cliente Nº\t36\n\tORIGINAL\nwww.brvr.pt\t\t\t\t\t\t\tPágina 1 de 1\n\nCliente\tV/ Contribuinte\tCondições de Pagamento\tRequisição\tData\tPrazo de Entrega\n976\t505781417\t\t\t\t\t22.09.2023\nSoftware PHC - Emitido por programa certificado nº 0006/AT (20221106.45738)-Este documento não serve de\nReferência Designação\t\t\t\tQuantidade\tValor Unitário Desc. Desc2. Total\nTONOKI4446 Toner OKI C510/C511/C530/C531/MC561/MC562 Yellow (5K)\t1,0 Uni\nTONOKI4446 Toner OKI C510/C511/C530/C531/MC561/MC562\tMagenta (5K)\t1,0 Uni\nTONOKI4446 Toner OKI C510/C511/C530/C531/MC561/MC562\tCyan (5K)\t1.0 Uni\nTONOKI4497 Toner OKI C511/C531/MC562 Preto (7K)\t\t1,0 Uni\nCF244A\tToner HP 44A Preto - LaserJet Pro M15/28\t\t1,0 Uni\n\nDocumento Processado por Computador\nObs.:\n\nSoftware PHC - Emitido por programa certificado nº 0006/AT (20221106.45738)-Este documento não serve de fatura\nTaxa\tBase de Incidência Valor do I.V.A.\t\tTotal antes de descontos\n23.00%\t\t\t\t\t\tDesconto Comercial\n\tDesconto Financeiro\n\tTotal lliquido\n\tTOTAL DO DOCUMENTO\n\nContribuinte n.° 507460146\tCapital Social 5 000,00 €uros\tConserv.Reg.Com. P. de Varzim\tN° Matrícula\t370", "order_date": null, "payment": {"card_number": null, "display_name": null, "terms": null, "type": null}, "pdf_url": "https://scdn.veryfi.com/receipts/2734e8bc88daecc3/72382b7b-5059-4d75-8ce1-a8ecc63875d4/90c87077-aa8e-4593-98ef-e54fa2fae03d.pdf?Expires=1695828184&Signature=JB5G0EtpLjYxC4g4MxXbCT-MNenHRZqs7f0vKkUN1mHGO0pC3zGvVpzMkNtvSl6fKT2pfPVkJHj2vfpokOZOIxlbO89C6nFemXkjtCmXsbnlsFWxtRSQYoIjU~kTA6P2ehgdP-gj6TOA9xu~8xNbbaZMxMHTuTDC1o4p3vsYqA3Keo7251Q1itA-aC4mzMrT5TPvbo6X1ZDzag4NZxu7BID4ZrsFvvXp6MXGcDWo0CY6K1fQTBajn8GyQNcc09a2mtuiCbPjelzCSFB3bGZAndP9hOS05T89Ide1dbjSQuRCSeZnG71QUZta4z-jQ3bCY6XYjxdQ6bVypmn5IC33Aw__&Key-Pair-Id=APKAJCILBXEJFZF4DCHQ", "purchase_order_number": null, "reference_number": "VBEAE-10905", "rounding": null, "service_end_date": null, "service_start_date": null, "ship_date": null, "ship_to": {"address": "RUA ANTÓNIO GRAÇA, N°131 R/C\nPovoa de Varzim\nRUA ANTÓNIO GRAÇA, N°131 R/C\n4490-471 Póvoa de Varzim", "name": "AGENCIA FUNERÁRIA POVEIRA LDA", "parsed_address": null}, "shipping": null, "store_number": null, "subtotal": 5000.0, "tags": [], "tax": null, "tax_lines": [], "tip": null, "total": 5000.0, "total_weight": null, "tracking_number": null, "updated_date": "2023-09-27 15:08:04", "vendor": {"abn_number": null, "account_number": null, "address": null, "bank_name": null, "bank_number": null, "bank_swift": null, "category": null, "email": null, "fax_number": null, "iban": null, "lat": null, "lng": null, "logo": "https://cdn.veryfi.com/logos/tmp/3bee5197-3a54-465b-a0dd-efbabbe1c128.png", "name": "Informática E Serviços, Lda", "phone_number": "252 646 260", "raw_address": null, "raw_name": "Informática e Serviços, Lda", "reg_number": null, "type": null, "vat_number": "507460146", "web": "www.brvr.pt"}}'; 

        /********************************** */

       /********** OCR MINDEE **************/    
       
        // $cFile = global_tenancy_asset('/app/scans/'.$random.'.png');

        // $curl = curl_init();

        // curl_setopt_array($curl, [
        // CURLOPT_URL => "https://api.mindee.net/v1/products/mindee/invoices/v4/predict",
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => "",
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 30,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        // CURLOPT_CUSTOMREQUEST => "POST",
        // CURLOPT_POSTFIELDS => json_encode([
        //     'document' => $cFile,
        // ]),
        // CURLOPT_HTTPHEADER => [
        //     "Accept: application/json",
        //     "Content-Type: application/json",
        //     "Authorization: Token f4dd6e5acf08d6c4c4b33d625d01c91b"
        // ],
        // ]);

        // $response = curl_exec($curl);

        // curl_close($curl);

        //FICHEIRO DA BOXPT
        $response = '{"api_request": {"error": {}, "resources": ["document"], "status": "success", "status_code": 201, "url": "https://api.mindee.net/v1/products/mindee/invoices/v4/predict"}, "document": {"id": "b07d3fae-ea27-4a3b-9a23-a477c589e4a4", "inference": {"extras": {}, "finished_at": "2023-09-28T11:28:03.717621", "is_rotation_applied": true, "pages": [{"extras": {}, "id": 0, "orientation": {"value": 0}, "prediction": {"customer_address": {"confidence": 0.55, "polygon": [[0.069, 0.197], [0.213, 0.197], [0.213, 0.234], [0.069, 0.234]], "value": "Rua da Liberdade n\u00b0 100 Trofa 4785 024"}, "customer_company_registrations": [{"confidence": 0.99, "polygon": [[0.567, 0.751], [0.642, 0.751], [0.642, 0.762], [0.567, 0.762]], "type": "VAT NUMBER", "value": "PT510618359"}], "customer_name": {"confidence": 0.72, "polygon": [[0.069, 0.185], [0.233, 0.185], [0.233, 0.197], [0.069, 0.197]], "raw_value": "One More Personal Training", "value": "ONE MORE PERSONAL TRAINING"}, "date": {"confidence": 0.99, "polygon": [[0.43, 0.052], [0.496, 0.052], [0.496, 0.065], [0.43, 0.065]], "value": "2023-09-26"}, "document_type": {"value": "INVOICE"}, "due_date": {"confidence": 0.0, "polygon": [], "value": null}, "invoice_number": {"confidence": 0.0, "polygon": [], "value": null}, "line_items": [{"confidence": 0.84, "description": "BOXPT Bola de Arremesso em PVC \"\"slm Ball\" 5kg", "polygon": [[0.067, 0.359], [0.94, 0.359], [0.94, 0.374], [0.067, 0.374]], "product_code": "SLAMBO05", "quantity": 1.0, "tax_amount": 30.0, "tax_rate": 23.0, "total_amount": 11.95, "unit_price": 17.07}, {"confidence": 0.88, "description": "BOXP Bola de Arremesso em PVC \"Slam Ball\" 10kg", "polygon": [[0.067, 0.376], [0.94, 0.376], [0.94, 0.391], [0.067, 0.391]], "product_code": "SL LAMB009", "quantity": 1.0, "tax_amount": 30.0, "tax_rate": 23.0, "total_amount": 14.8, "unit_price": 21.14}, {"confidence": 0.95, "description": "BOXPT Corda de Saltar \"Hero\" em Aluminio Preto", "polygon": [[0.067, 0.394], [0.94, 0.394], [0.94, 0.407], [0.067, 0.407]], "product_code": "SROPE STB", "quantity": 2.0, "tax_amount": 25.0, "tax_rate": 23.0, "total_amount": 15.86, "unit_price": 10.57}, {"confidence": 0.91, "description": "BOXPT Saco de Peso \"Power Bag\" 15kg", "polygon": [[0.067, 0.411], [0.94, 0.411], [0.94, 0.425], [0.067, 0.425]], "product_code": "SB0015", "quantity": 1.0, "tax_amount": 25.0, "tax_rate": 23.0, "total_amount": 40.85, "unit_price": 54.47}, {"confidence": 0.95, "description": "BOXPT Arruma\u00e7ao de Parede para Colchoes de Treino", "polygon": [[0.067, 0.428], [0.942, 0.428], [0.942, 0.442], [0.067, 0.442]], "product_code": "ARRUMCOLCHO", "quantity": 1.0, "tax_amount": 20.0, "tax_rate": 23.0, "total_amount": 21.46, "unit_price": 26.83}, {"confidence": 0.85, "description": "BOXPT Pavimento em Borracha Quadrado 1/1m 20mm", "polygon": [[0.065, 0.445], [0.94, 0.445], [0.94, 0.46], [0.065, 0.46]], "product_code": "PAVQUAO20", "quantity": 4.0, "tax_amount": 18.0, "tax_rate": 23.0, "total_amount": 101.32, "unit_price": 30.89}, {"confidence": 0.92, "description": "Portes de Envio", "polygon": [[0.065, 0.463], [0.802, 0.463], [0.802, 0.475], [0.065, 0.475]], "product_code": "PORTES", "quantity": 1.0, "tax_amount": 100.0, "tax_rate": 23.0, "total_amount": null, "unit_price": 35.0}], "locale": {"confidence": 0.81, "currency": "EUR", "language": "pt"}, "orientation": {"confidence": 0.99, "degrees": 0}, "reference_numbers": [{"confidence": 0.75, "polygon": [[0.245, 0.341], [0.289, 0.341], [0.289, 0.353], [0.245, 0.353]], "value": "no1720"}, {"confidence": 0.19, "polygon": [[0.31, 0.589], [0.387, 0.589], [0.387, 0.6], [0.31, 0.6]], "value": "certificadon1"}], "supplier_address": {"confidence": 0.18, "polygon": [[0.065, 0.734], [0.247, 0.734], [0.247, 0.768], [0.065, 0.768]], "value": "Parque Industrialde BoticasL ote 13 5460-344 Boticas Portugal"}, "supplier_company_registrations": [{"confidence": 0.99, "polygon": [[0.389, 0.186], [0.48, 0.186], [0.48, 0.199], [0.389, 0.199]], "type": "VAT NUMBER", "value": "PT516548050"}], "supplier_name": {"confidence": 0.49, "polygon": [[0.07, 0.078], [0.205, 0.078], [0.205, 0.09], [0.07, 0.09]], "raw_value": "Atitudes de Epoca,Lda", "value": "ATITUDES DE EPOCA,LDA"}, "supplier_payment_details": [{"account_number": null, "confidence": 0.99, "iban": "PT50003506660008874573098", "polygon": [[0.158, 0.675], [0.369, 0.675], [0.369, 0.69], [0.158, 0.69]], "routing_number": null, "swift": null}, {"account_number": null, "confidence": 0.99, "iban": "PT50001800034100564602020", "polygon": [[0.156, 0.662], [0.365, 0.662], [0.365, 0.674], [0.156, 0.674]], "routing_number": null, "swift": null}], "taxes": [], "total_amount": {"confidence": 0.99, "polygon": [[0.899, 0.683], [0.943, 0.683], [0.943, 0.695], [0.899, 0.695]], "value": 253.68}, "total_net": {"confidence": 0.99, "polygon": [[0.899, 0.655], [0.943, 0.655], [0.943, 0.669], [0.899, 0.669]], "value": 206.24}}}], "prediction": {"customer_address": {"confidence": 0.55, "page_id": 0, "polygon": [[0.069, 0.197], [0.213, 0.197], [0.213, 0.234], [0.069, 0.234]], "value": "Rua da Liberdade n\u00b0 100 Trofa 4785 024"}, "customer_company_registrations": [{"confidence": 0.99, "page_id": 0, "polygon": [[0.567, 0.751], [0.642, 0.751], [0.642, 0.762], [0.567, 0.762]], "type": "VAT NUMBER", "value": "PT510618359"}], "customer_name": {"confidence": 0.72, "page_id": 0, "polygon": [[0.069, 0.185], [0.233, 0.185], [0.233, 0.197], [0.069, 0.197]], "raw_value": "One More Personal Training", "value": "ONE MORE PERSONAL TRAINING"}, "date": {"confidence": 0.99, "page_id": 0, "polygon": [[0.43, 0.052], [0.496, 0.052], [0.496, 0.065], [0.43, 0.065]], "value": "2023-09-26"}, "document_type": {"value": "INVOICE"}, "due_date": {"confidence": 0.0, "page_id": null, "polygon": [], "value": null}, "invoice_number": {"confidence": 0.0, "page_id": null, "polygon": [], "value": null}, "line_items": [{"confidence": 0.84, "description": "BOXPT Bola de Arremesso em PVC \"\"slm Ball\" 5kg", "page_id": 0, "polygon": [[0.067, 0.359], [0.94, 0.359], [0.94, 0.374], [0.067, 0.374]], "product_code": "SLAMBO05", "quantity": 1.0, "tax_amount": 30.0, "tax_rate": 23.0, "total_amount": 11.95, "unit_price": 17.07}, {"confidence": 0.88, "description": "BOXP Bola de Arremesso em PVC \"Slam Ball\" 10kg", "page_id": 0, "polygon": [[0.067, 0.376], [0.94, 0.376], [0.94, 0.391], [0.067, 0.391]], "product_code": "SL LAMB009", "quantity": 1.0, "tax_amount": 30.0, "tax_rate": 23.0, "total_amount": 14.8, "unit_price": 21.14}, {"confidence": 0.95, "description": "BOXPT Corda de Saltar \"Hero\" em Aluminio Preto", "page_id": 0, "polygon": [[0.067, 0.394], [0.94, 0.394], [0.94, 0.407], [0.067, 0.407]], "product_code": "SROPE STB", "quantity": 2.0, "tax_amount": 25.0, "tax_rate": 23.0, "total_amount": 15.86, "unit_price": 10.57}, {"confidence": 0.91, "description": "BOXPT Saco de Peso \"Power Bag\" 15kg", "page_id": 0, "polygon": [[0.067, 0.411], [0.94, 0.411], [0.94, 0.425], [0.067, 0.425]], "product_code": "SB0015", "quantity": 1.0, "tax_amount": 25.0, "tax_rate": 23.0, "total_amount": 40.85, "unit_price": 54.47}, {"confidence": 0.95, "description": "BOXPT Arruma\u00e7ao de Parede para Colchoes de Treino", "page_id": 0, "polygon": [[0.067, 0.428], [0.942, 0.428], [0.942, 0.442], [0.067, 0.442]], "product_code": "ARRUMCOLCHO", "quantity": 1.0, "tax_amount": 20.0, "tax_rate": 23.0, "total_amount": 21.46, "unit_price": 26.83}, {"confidence": 0.85, "description": "BOXPT Pavimento em Borracha Quadrado 1/1m 20mm", "page_id": 0, "polygon": [[0.065, 0.445], [0.94, 0.445], [0.94, 0.46], [0.065, 0.46]], "product_code": "PAVQUAO20", "quantity": 4.0, "tax_amount": 18.0, "tax_rate": 23.0, "total_amount": 101.32, "unit_price": 30.89}, {"confidence": 0.92, "description": "Portes de Envio", "page_id": 0, "polygon": [[0.065, 0.463], [0.802, 0.463], [0.802, 0.475], [0.065, 0.475]], "product_code": "PORTES", "quantity": 1.0, "tax_amount": 100.0, "tax_rate": 23.0, "total_amount": null, "unit_price": 35.0}], "locale": {"confidence": 0.81, "currency": "EUR", "language": "pt"}, "reference_numbers": [{"confidence": 0.75, "page_id": 0, "polygon": [[0.245, 0.341], [0.289, 0.341], [0.289, 0.353], [0.245, 0.353]], "value": "no1720"}, {"confidence": 0.19, "page_id": 0, "polygon": [[0.31, 0.589], [0.387, 0.589], [0.387, 0.6], [0.31, 0.6]], "value": "certificadon1"}], "supplier_address": {"confidence": 0.18, "page_id": 0, "polygon": [[0.065, 0.734], [0.247, 0.734], [0.247, 0.768], [0.065, 0.768]], "value": "Parque Industrialde BoticasL ote 13 5460-344 Boticas Portugal"}, "supplier_company_registrations": [{"confidence": 0.99, "page_id": 0, "polygon": [[0.389, 0.186], [0.48, 0.186], [0.48, 0.199], [0.389, 0.199]], "type": "VAT NUMBER", "value": "PT516548050"}], "supplier_name": {"confidence": 0.49, "page_id": 0, "polygon": [[0.07, 0.078], [0.205, 0.078], [0.205, 0.09], [0.07, 0.09]], "raw_value": "Atitudes de Epoca,Lda", "value": "ATITUDES DE EPOCA,LDA"}, "supplier_payment_details": [{"account_number": null, "confidence": 0.99, "iban": "PT50003506660008874573098", "page_id": 0, "polygon": [[0.158, 0.675], [0.369, 0.675], [0.369, 0.69], [0.158, 0.69]], "routing_number": null, "swift": null}, {"account_number": null, "confidence": 0.99, "iban": "PT50001800034100564602020", "page_id": 0, "polygon": [[0.156, 0.662], [0.365, 0.662], [0.365, 0.674], [0.156, 0.674]], "routing_number": null, "swift": null}], "taxes": [], "total_amount": {"confidence": 0.99, "page_id": 0, "polygon": [[0.899, 0.683], [0.943, 0.683], [0.943, 0.695], [0.899, 0.695]], "value": 253.68}, "total_net": {"confidence": 0.99, "page_id": 0, "polygon": [[0.899, 0.655], [0.943, 0.655], [0.943, 0.669], [0.899, 0.669]], "value": 206.24}}, "processing_time": 2.715, "product": {"features": ["locale", "invoice_number", "reference_numbers", "date", "due_date", "total_net", "total_amount", "taxes", "supplier_payment_details", "supplier_name", "supplier_company_registrations", "supplier_address", "customer_name", "customer_company_registrations", "customer_address", "document_type", "orientation", "line_items"], "name": "mindee/invoices", "type": "standard", "version": "4.2"}, "started_at": "2023-09-28T11:28:01.002694"}, "n_pages": 1, "name": "9255757372.png"}}';    

       /********************************** */
        
        

        $response_decoded = json_decode($response);

        $arrayLines = [];

       
        foreach($response_decoded->document->inference->pages as $i => $line)
        {
            foreach($line->prediction->line_items as $t => $item)
            {
                $arrayLines[$t] = [
                    "referencias" => $item->product_code,
                    "designacoes" => $item->description,
                    "qtd" => $item->quantity,
                    "qtdrececionada" => $item->quantity,
                    "preco" => (float)$item->total_amount/$item->quantity
                ];
            }

            $array_encomenda = [
                "numero_encomenda" => $line->prediction->invoice_number->value,
                "nome_fornecedor" => $line->prediction->supplier_name->raw_value,
                "nif_fornecedor" => $line->prediction->supplier_company_registrations[0]->value,
                "data_documento" => $line->prediction->date->value,
                "linhas_encomenda" => json_encode($arrayLines),
                "imagem" => $imagem_link,
                "preco_final" => $line->prediction->total_amount->value
            ];
        }
      


        Encomendas::Create($array_encomenda);   
               

        $this->dispatchBrowserEvent('swalFire', ['title' => "Scan Encomenda", 'message' => "Encomenda recebida com sucesso", 'status' => 'success']);
                
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


    public function render()
    {   
        
        // **  Numero de encomendas de fornecedor abertos  **/

        if(isset($this->searchString) && $this->searchString) {
            $this->encomendas = $this->encomendaRepository->getEncomendasSearch($this->searchString,$this->perPage);
        } else {
            $this->encomendas = $this->encomendaRepository->getEncomendas($this->perPage);
        }

        
        return view('tenant.livewire.encomendas.rececao',["encomendas" => $this->encomendas]);
    }
}
