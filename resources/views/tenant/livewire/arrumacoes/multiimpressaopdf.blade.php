<div>

        @foreach($object as $imp)
            <table style="width: 100%;font-size:25px;">
                <tr style="text-align:center;margin-left:20px;">
                    
                        <td style="text-align:center;">{!! DNS1D::getBarcodeHTML($imp["reference"], "C128",2.7,50) !!}</td>
                
                </tr>
                <tr style="width:100%;">
                    <td>{{ $imp["designacao"] }}</td>
                </tr>   
                <tr>
                    <td>Qtd: {{ $imp["qtd"] }}</td>
                </tr>
                <tr>
                    <span style="visibility: hidden;">fsd</span>
                </tr>
                <tr>
                    <span style="visibility: hidden;">Teste</span>
                </tr>
                               
            </table>
        @endforeach
 
</div>