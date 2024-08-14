<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Open Sans',sans-serif;
            margin: 0;
            padding: 0;
        }
     
        header {
            position: fixed;
            top: -130px;
            left: 0;
            right: 0;
            height: 100px;
            text-align: center;
            z-index: 1;
        }

        footer {
            position: fixed;
            bottom: -100px;
            left: 0;
            right: 0;
            height: 100px;
            text-align: center;
            line-height: 40px;
            font-size: 14px;
            z-index: 1;
        }

        .logo {
            float: left;
            margin-left: 30px;
        }
        .invoice-title {
            float: right;
            margin-right: 30px;
            font-size: 32px;
            font-weight: bold;
        }
        .clearfix {
            clear: both;
        }
        .sub-title {
            margin: 0;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .bordered-table, .bordered-table tr, .bordered-table td, .bordered-table th{
      border: 1px solid #c2c2c2;
      border-collapse: collapse;
    }
    .bordered-table td, .bordered-table th{
      padding: 5px;
      height: 18px;
    }
    table{
      width: 100%;
    }


    @page { margin: 75px 25px; }
    body{
      font-family: 'Open Sans',sans-serif;
      font-size: 12px;
    }
    header { 
      position: fixed; 
      top: -60px; 
      left: 0px; 
      right: 0px;
      height: 90px;
    }
    footer { 
      position: fixed; 
      bottom: -60px; 
      left: 0px; 
      right: 0px;
      height: 30px;
      text-align: center;
      color: #ffffff;
      background-color: #d93791;
      /*background-image: linear-gradient(to right, #d93791 , #39b3b9);*/
    }
    table{
      width: 100%;
    }
    .bordered-table, .bordered-table tr, .bordered-table td, .bordered-table th{
      border: 1px solid #c2c2c2;
      border-collapse: collapse;
    }
    .bordered-table td, .bordered-table th{
      padding: 5px;
      height: 18px;
    }
    .mt-2{
      margin-top: 2em;
    }
    .float-left{
      float: left;
    }
    .bold{
      font-weight: bold;
    }
    input{
      display: inline-block;
      margin-bottom: -7px
    }
    .underline{
      color: red;
    }
    #freeform{
      width: 100%;
      height: 30px;
      border: 1px solid #c2c2c2;
      padding: 5px;
    }
    .blue-title{
      color: #6075b8;
      font-weight: bold;
      font-size: 13px;
    }
    .circle{
      border: 1px solid #000000; 
      border-radius: 100px; 
      display: inline-block; 
      height: 15px; 
      width: 15px; 
      text-align: center; 
      padding: 2px; 
      margin-bottom: -6px;
    }
    .circle2{
      border: 1px solid #000000; 
      border-radius: 100px; 
      display: inline-block; 
      height: 15px; 
      width: 50px; 
      text-align: center; 
      padding: 2px; 
      margin-bottom: -6px;
    }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <!-- @if ($companyLogo)
            <img src="{{ $companyLogo }}" style="width:100px;">
            @endif -->
        </div>
        <div class="invoice-title">WORK ORDER</div>
        <div class="clearfix"></div>
    </header>
    <footer>
        © 2024 COPYRIGHT BY {{ $companyName ?? '69-TOOLS' }} WHERE QUALITY MATTERS
    </footer>
    <div class="invoice-box">
        <table class="bordered-table">
            <!-- <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                <h4 class="sub-title">Billed To:</h4>
                                {{$data->name}}<br>
                                {{$data->phone}}<br>
                            </td>
                            <td class="text-right">
                                Invoice No. {{$data->invoice_no}}<br>
                                {{$data->created_at}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr> -->
            <tr>
                <td> Invoice No. {{$data->invoice_no}} </td>
                <td> Date: {{ \Carbon\Carbon::parse($data->created_at)->format('m-d-Y') }}</td>
                <td> Day: {{ date('l', strtotime($data->created_at)) }}</td>
                <td> Vehicle:  {{$data->year}} - {{$data->make}} - {{$data->model}} </td>
            </tr>
            <tr>
                <td colspan="2" >Customer: {{$data->name}}</td>
                <td colspan="2" >Phone: {{$data->phone}}</td>
            </tr>
        </table>
        <div class="section3 mt-2">
      <table class="bordered-table">
        <tr>
          <th class="blue-title" style="background-color: #f2f2f2;" colspan="8">
            REQUESTED SHADES AND TYPE OF FILM
          </th>
          <th class="blue-title" colspan="2" style="background-color: #f2f2f2;" >
           Tint Brand used
          </th>
        </tr>
        <tr>
          <td colspan="8">
            <div class="float-left" style="width: 25%;">
              <span class="bold">Front Windows :</span> 
            </div>
            <div class="float-left">
            <span class="ps-4">5 </span>/
            <span class="ps-4">20 </span>/
            <span class="ps-4">30 </span>/
            <span class="ps-4">35 </span>/
            <span class="ps-4">45 </span>/
            <span class="ps-4">50 </span>/
            <span class="ps-4">70 </span>
            <span class="ps-4"> %VLT</span>
              </td>
          <td colspan="2">
          </td>
        </tr>
        <tr>
          <td colspan="8">
            <div class="float-left" style="width: 25%;">
              <span class="bold">Back windows :</span> 
            </div>
            <div class="float-left">
            <span class="ps-4 ">5 </span>/
            <span class="ps-4 ">20  </span>/
            <span class="ps-4 ">30 </span>/
            <span class="ps-4 ">35 </span>/
            <span class="ps-4 ">45 </span>/
            <span class="ps-4 ">50 </span>/
            <span class="ps-4 ">70 </span>
              <span class="ps-4"> %VLT</span> 
            </div>
          </td>
          <td colspan="2">
          </td>
        </tr>
        <tr>
          <td colspan="8">
            <div class="float-left" style="width: 25%;">
              <span class="bold">Front Windshield :</span> 
            </div>
            <div class="float-left">
            <span class="ps-4 ">5  </span>/
            <span class="ps-4 ">20 </span>/
            <span class="ps-4 ">30 </span>/
            <span class="ps-4 ">35 </span>/
            <span class="ps-4 ">45 </span>/
            <span class="ps-4 ">50 </span>/
            <span class="ps-4 ">70 </span>
             <span class="ps-4"> %VLT</span> 
            </div>
          </td>
          <td colspan="2">
          </td>
        </tr>
        <tr>
          <td colspan="8">
            <div class="float-left" style="width: 25%;">
              <span class="bold">Windshield Strip :</span>
            </div>
            <div class="float-left">
            <span class="ps-4 ">5  </span>/
            <span class="ps-4 ">20  </span>/
            <span class="ps-4 ">30 </span>/
            <span class="ps-4 ">35 </span>/
            <span class="ps-4 ">45 </span>/
            <span class="ps-4 ">50 </span>/
            <span class="ps-4 ">70 </span>
              <span class="ps-4"> %VLT</span> 
            </div>
          </td>
          <td colspan="2">
          </td>
        </tr>
        <tr>
          <td colspan="8">
            <div class="float-left" style="width: 25%;">
              <span class="bold">Moonroof:</span>
            </div>
            <div class="float-left">
            <span class="ps-4 ">5 </span>/
            <span class="ps-4  ">20 </span>/
            <span class="ps-4 ">30</span>/
            <span class="ps-4  ">35</span>/
            <span class="ps-4  ">45</span>/
            <span class="ps-4  ">50</span>/
            <span class="ps-4  f">70 </span>
              <span class="ps-4"> %VLT</span> 
            </div>
          </td>
          <td colspan="2">
          </td>
         
        </tr>
      </table>
    </div>
    <div class="section4 mt-2">
      <table>
        <tr>
        <td colspan="10"> 
            <span class="bold">PPF/Ceramic coating:</span>
            <span class="ps-5  ">Patrial front</span>/
            <span class="ps-5 ">Full front</span>/
            <span class="ps-5 ">Track pack</span>/
            <span class="ps-5   ">Full kit</span>
        </td>
        </tr>
        <tr>
          <td colspan="10">
            <span >Ceramic Coating Car:</span>
            <span class="pe-2">1</span>
            <span class="pe-2">2</span>
            <span class="pe-2">3</span>
            <span class="pe-2">4</span>
            <span class="pe-2">5</span>
            <span class="pe-2">6</span>
            <span class="pe-2">7</span>
            <span class="pe-5"></span>
          </td>
        </tr>
        <tr>
          <td colspan="10">
            <span class="bold">Paint Correction:</span>
            <span class="pe-2">1</span>
            <span class="pe-2">2</span>
            <span class="pe-2">3</span>
            <span class="pe-2">4</span>
            <span class="pe-5"></span>
          </td>
        </tr>
        <tr>
          <td colspan="10">
            <span class="bold">Light tint:</span>
            <span class="pe-2">1</span>
            <span class="pe-2">2</span>
            <span class="pe-2">3</span>
            <span class="pe-2">4</span>
            <span class="pe-5"></span>
          </td>
        </tr>
        <tr>
          <td colspan="10">
            <span class="bold">Detailng</span>
            <span class="pe-2">in</span>
            <span class="pe-2">out</span>
            <span class="pe-5">in & out</span>
          </td>
        </tr>
      </table>
    </div>
        <!-- <table class="main-table">
            <tr class="heading">
                <td class="ps-20">Item</td>
                <td>Type</td>
                <td class="text-center" width="80px">Price</td>
                <td class="text-center" width="80px">Total</td>
            </tr>
            @php $total = 0;@endphp
            @foreach($data->invoiceDetails as $details)
            @php $total = $total + $details->price; @endphp
                <tr class="item">
                    <td class="ps-20">{{ $details->item }}</td>
                    <td>{{ $details->item_type }}</td>
                    <td class="text-center">${{ $details->price }}</td>
                    <td class="text-center">${{ $total }}</td>
                </tr>
            @endforeach
            <tr class="total">
                <td></td>
                <td></td>
                <td class="text-center">Subtotal</td>
                <td class="text-center">${{ $data->total }}</td>
            </tr>
            <tr class="total">
                <td></td>
                <td></td>
                <td class="text-center">Total</td>
                <td class="text-center">${{ $data->total }}</td>
            </tr>
        </table> -->
        <!-- <div class="thank-you">
            Thank you!
        </div> -->
    </div>
</body>
</html>
