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
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 0 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table.main-table td{
            padding: 5 20px;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total:last-child td:nth-last-child(-n+2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        .invoice-box .total td {
            padding: 10px;
        }
        .invoice-box .thank-you {
            margin-top: 20px;
            font-size: 24px;
        }

        @page {
            margin: 180px 0 80px;
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
    </style>
</head>
<body>
    <header>
        <div class="logo">
            @if ($companyLogo)
            <img src="{{ $companyLogo }}" style="width:100px;">
            @endif
        </div>
        <div class="invoice-title">WORK ORDER</div>
        <div class="clearfix"></div>
    </header>
    <footer>
        © 2024 COPYRIGHT BY 69-TOOLS WHERE QUALITY MATTERS
    </footer>
    <div class="invoice-box">
        <table>
            <tr class="information">
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
            </tr>
        </table>
        <table class="main-table">
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
        </table>
        <!-- <div class="thank-you">
            Thank you!
        </div> -->
    </div>
</body>
</html>
