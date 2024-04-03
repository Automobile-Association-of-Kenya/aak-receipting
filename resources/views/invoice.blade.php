<?php

function asMoney($value)
{
    return number_format(clean($value), 2);
}

function clean($var)
{
    return preg_replace('/[^0-9.]/', '', $var);
}
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ 'Invoice' }}</title>
    <style type="text/css">
        table {
            max-width: 100%;
            background-color: transparent;
        }

        th {
            text-align: left;
        }

        .table {
            width: 100%;
            margin-bottom: 2px;
        }

        .table-bordered th {
            padding: .1em 1em;
            font-weight: 400;
            font-size: 12px;
        }

        hr {
            margin-top: 1px;
            margin-bottom: 2px;
            border: 0;
            border-top: 2px dotted #eee;
        }

        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 11px;
            line-height: 1.428571429;
            background-color: #fff;
        }

        .header {
            position: fixed;
            left: 0px;
            top: -100px;
            right: 0px;
            height: 190px;
            text-align: center;
            margin-bottom: .6em;
        }

        .footer {
            position: fixed;
            left: 0px;
            bottom: -20px;
            right: 0px;
            height: 40px;
        }

        .footer .page:after {
            content: counter(page, upper-roman);
        }

        .content {
            margin-top: -2em;
            margin-bottom: 1em;
        }

        @page {
            margin-top: 100px;
            margin-bottom: 60px;
        }
        td{
            padding: .3em 1em
        }
    </style>
</head>

<body>
    <div class="header" style="margin-bottom: 3em;">
        <table class="thead" style="width: 100%;">
            <tr>
                <td style="text-align: left;">
                    <img src="img/logo.png" alt="logo" width="180px" height="150px">
                </td>
                <td style="text-align: right;">
                    <p style="font-size: 14px;"><strong>Automobile Association of Kenya</strong><br>
                        RENAISSANCE CORPORATE PARK, ELGON RD<br>
                        P.O BOX 40087 - 00100<br>
                        NAIROBI<br></p>
                </td>
            </tr>
        </table>
    </div>
    <h5
        style="font-size: 20px; font-weight: 500; align-items:center; justify-content:center; text-align: center; border-bottom:1px solid #444;">
        <strong>{{ 'Invoice' }}</strong>
    </h5>

    <div class="content">
        <div class="post-header">
            <table style="width: 98%; margin-bottom: .8em;">
                <tr>
                    <td style="text-align: left">
                        <span><b>Invoice NO:</b> <b>{{ $invoice->invoice_no }}</b></span><br>
                        <span><b>Customer NO:</b> <b>{{ $invoice->member->MembershipNumber }}</b></span><br>
                        <span><b>Customer:</b>
                            {{ $invoice->member->firstName . ' ' . $invoice->member->secondName . ' ' . $invoice->member->surNameName }}</span><br>
                        <span><b>Posting Date:</b> {{ date('j M Y', strtotime($invoice->date)) }}</span><br>
                    </td>

                    <td style="text-align: right;">
                        <span style="text-align: left"><strong>Company Pin.</strong>&nbsp;&nbsp;P0006064871</span><br>
                        <span style="text-align: left"><strong>VAT NO.</strong>&nbsp;&nbsp;</span><br>
                        <span style="text-align: left"><strong>Customer Pin:</strong>&nbsp;&nbsp;</span>
                    </td>
                </tr>
            </table>
        </div>

        <table class="table table-bordered" cellspacing="0" cellpadding="0" border="1" style="border:1px solid #333;">
            <thead>
                <tr>
                    <th><strong>Description</strong></th>
                    <th><strong>NO</strong></th>
                    <th><strong>Amount</strong></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                    $total = 0;
                @endphp
                @foreach ($invoice->items as $item)
                    @php
                        $total += $item->amount;
                    @endphp
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ asMoney((float) $item->amount) }}</td>
                    </tr>
                @endforeach
                @php
                    $tax = ($total / 1.16) * 0.16;
                    $grandtotal =$total;
                @endphp
            </tbody>
            <tfoot>
                <tr>
                <td></td>

                <td><strong>Amount Excluding Tax</strong></td>
                <td>
                    <strong>{{ asMoney((float) $grandtotal-$tax) }}</strong>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><strong>Tax: </strong></td>
                <td>
                    <strong>{{ asMoney($tax) }}</strong>
                </td>
            </tr>
            <tr>
                <td>NO: &nbsp;&nbsp; <span
                        style="color: #006524; font-size: 16px; font-weight: 200;">{{ $invoice->invoice_no }}</span>
                </td>
                <td><strong>Total</strong></td>
                <td>
                    <strong>{{ asMoney($grandtotal) }}</strong>
                </td>
            </tr>
            </tfoot>
        </table>

        {{-- <p style="text-align: center;">Goods once sold cannot be Returned</p>
      <p style="text-align: center;">Thank you for your support. Welcome again. </p> --}}
    </div>
</body>

</html>
