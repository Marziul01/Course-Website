<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
        font-family: 'SolaimanLipi', sans-serif; /* Ensure this matches the PDF generation font */
        margin: 0;
        padding: 20px;
        color: #333;
    }
    .bangla {
        font-family: 'SolaimanLipi', sans-serif; /* Ensure Bangla text uses the correct font */
    }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
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

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="https://learnerslamp.com/frontend-assets/imgs/sitelogoinvoice.png" style="width: 150px; height: auto;">
                            </td>

                            <td>
                                Invoice #: {{ $order->id }}<br>
                                Created: {{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}<br>

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                House 15, Road 5/D,<br> Sector 11, Uttara,<br> Dhaka - 1230
                            </td>

                            <td>
                                {{ $order->name }}<br>
                                {{ $order->email }}<br>
                                {{ $order->phone }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Payment Method</td>
                <td>Amount</td>
            </tr>

            <tr class="details">
                <td>{{ $order->payment->name }}</td>
                <td>{{ number_format($order->grand_total, 2) }} BDT</td>
            </tr>

            <tr class="heading">
                <td>Item</td>
                <td>Price</td>
            </tr>

            @foreach($order->items as $item)
            <tr class="item">
                <td>{{ $item->course->title }}</td>
                <td>{{ number_format($item->course->sale_price ?? $item->course->price ) }} BDT</td>
            </tr>
            @endforeach

            <tr class="total">
                <td></td>
                <td>Total: {{ number_format($order->total, 2) }} BDT</td>
            </tr>
            <tr class="total">
                <td></td>
                <td>Discount: {{ number_format($order->discount, 2) }} BDT</td>
            </tr>
            <tr class="total">
                <td></td>
                <td>Grand Total: {{ number_format($order->grand_total, 2) }} BDT</td>
            </tr>
        </table>

        <p class="bangla">
            ধন্যবাদ! আপনার অর্ডার {{ $order->id }} সফলভাবে গ্রহণ করা হয়েছে।
        </p>

        <div class="footer">
            If you have any questions about this invoice, please contact us at info@example.com.
        </div>
    </div>
</body>
</html>
