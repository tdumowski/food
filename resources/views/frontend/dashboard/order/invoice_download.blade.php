<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Invoice</title>

        <style type="text/css">
            * {
            font-family: Verdana, Arial, sans-serif;
            }
            table{
                font-size: x-small;
            }
            tfoot tr td{
                font-weight: bold;
                font-size: x-small;
            }
            .gray {
                background-color: lightgray
            }
            .font{
                font-size: 15px;
            }
            .authority {
                /*text-align: center;*/
                float: right
            }
            .authority h5 {
                margin-top: -10px;
                color: green;
                /*text-align: center;*/
                margin-left: 35px;
            }
            .thanks p {
                color: green;
                font-size: 16px;
                font-weight: normal;
                font-family: serif;
                margin-top: 20px;
            }
        </style>

    </head>
    <body>
        <table width="100%" style="background: #F7F7F7; padding:0 20px 0 20px;">
            <tr>
                <td valign="top">
                    <!-- {{-- <img src="" alt="" width="150"/> --}} -->
                    <h2 style="color: green; font-size: 26px;"><strong>EasyShop</strong></h2>
                </td>
                <td align="right">
                    <pre class="font" >
                    EasyShop Head Office
                    Email:support@easylearningbd.com <br>
                    Mob: 1245454545 <br>
                    Dhaka 1207,Dhanmondi:#4 <br>

                    </pre>
                </td>
            </tr>

        </table>


        <table width="100%" style="background:white; padding:2px;"></table>

        <table width="100%" style="background: #F7F7F7; padding:0 5 0 5px;" class="font">
            <tr>
                <td>
                    <p class="font" style="margin-left: 20px;">
                    <strong>Name:</strong> {{ $order->name }} <br>
                    <strong>Email:</strong> {{ $order->email }} <br>
                    <strong>Phone:</strong> {{ $order->phone }} <br>

                    <strong>Address:</strong> {{ $order->address }} <br>
                    <strong>Post Code:</strong> 52-319
                    </p>
                </td>
                <td>
                    <p class="font">
                        <h3><span style="color: green;">Invoice:</span> #{{ $order->invoice_number }}</h3>
                        Order Date: {{ $order->order_date }} <br>
                        Delivery Date: {{ $order->delivered_date }} <br>
                        Payment Method: {{ $order->payment_method }} </span>
                    </p>
                </td>
            </tr>
        </table>

        <br/>
        <h3>Products</h3>

        <table width="100%">
            <thead style="background-color: green; color:#FFFFFF;">
                <tr class="font">
                    <th>s/n</th>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Code</th>
                    <th>Quantity</th>
                    <th>Restaurant name</th>
                    <th>Total </th>
                </tr>
            </thead>
            <tbody>

                @foreach ($orderItems as $key => $item)
                    <tr class="font">
                        <td align="center">
                            {{ $key + 1 }}
                        </td>
                        <td align="center">
                            <img src="{{ public_path($item->product->image) }}" height="60px" width="60px" alt="image">
                        </td>
                        <td align="center">{{ $item->product->name }}</td>
                        <td align="center">{{ $item->product->code }}</td>
                        <td align="center">{{ $item->quantity }}</td>
                        <td align="center">{{ $item->client->name }}</td>
                        <td align="center">$ {{ $item->price }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        <br>
        <table width="100%" style=" padding:0 10px 0 10px;">
            <tr>
                <td align="right" >
                <h2><span style="color: green;">Total:</span> $ {{ $totalPrice }}</h2>
                {{-- <h2><span style="color: green;">Full Payment PAID</h2> --}}
                </td>
            </tr>
        </table>

        <div class="thanks mt-3">
            <p>Thanks For Buying Products..!!</p>
        </div>
            <div class="authority float-right mt-5">
            <p>-----------------------------------</p>
            <h5>Authority Signature:</h5>
        </div>
    </body>
</html>