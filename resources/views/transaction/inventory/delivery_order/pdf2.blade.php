<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delivery Note</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            line-height: 1.4;
        }
    </style>
</head>

<body>
    <div style="position: relative;">
        <table style="width: 100%; height: 150px;">
            <tr>
                <td width="60%">
                </td>
                <td width="40%" style="padding: 20px;">
                    {{ date('d/m/Y') }}<br>
                    <strong>{{ $data->customer_name }}</strong><br>
                    {{ $data->destination_address }}
                </td>
            </tr>
        </table>

        <div style="position: absolute; top: 120px; right: 525px;">{{ $data->do_number }}</div>

        <table style="width: 100%; height: 175px; margin-bottom: 48px;">
            <thead>
                <tr>
                    <th width="25%"></th>
                    <th width="40%"></th>
                    <th width="15%"></th>
                    <th width="5%"></th>
                    <th width="15%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td class="text-center">{{ $item->sku_inventory_unit . ' ' . $item->sku_specification_code }}
                        </td>
                        <td>{{ $item->sku_name }}</td>
                        <td class="text-center">
                            @if ($option == 'customerDeliveryNumber')
                                @if ($item->source_type == 'CDS')
                                    {{ $item->customer_delivery_number_cds }}
                                @elseif($item->source_type == 'CR')
                                    {{ $item->customer_delivery_number_cr }}
                                @endif
                            @elseif ($option == 'customerPONumber')
                                @if ($item->source_type == 'CDS')
                                    {{ $item->po_number_cds }}
                                @elseif($item->source_type == 'CR')
                                    {{ $item->po_number_cr }}
                                @endif
                            @elseif($option == 'supplierPONumber')

                            @elseif($option == 'returnsDONumber')
                                @if ($item->source_type == 'CR')
                                    {{ $item->return_do_number_cr }}
                                @endif
                            @endif
                        </td>
                        <td class="text-center"></td>
                        <td class="text-center">{{ floatval($item->qty) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Tanda Tangan --}}
        <table style="width: 100%">
            <tr>
                <td width="75%"></td>
                <td width="25%">
                    <strong>{{ auth()->user()->name }}</strong>
                </td>
            </tr>
        </table>

        @if ($isOtherDestination)
            <div class="mt-10">
                @if ($items[0]->source_type == 'CDS')
                    <div>Destination: {{ $items[0]->delivery_destination_cds }}</div>
                    <div>Code: {{ $items[0]->delivery_destination_code_cds }}</div>
                @elseif($items[0]->source_type == 'CR')
                    <div>Destination: {{ $item->delivery_destination_cr }}</div>
                    <div>Code: {{ $items[0]->delivery_destination_code_cr }}</div>
                @endif
            </div>
        @endif

    </div>
</body>

</html>
