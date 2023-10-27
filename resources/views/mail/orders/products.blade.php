<x-mail::message>
# Order Payment Confirmation

## List of the Ordered products

@component("mail::table")
| Name | Description | Quantity | Price| Total | Currency
|:---------------:|:---------------:|:---------------:|:---------------:|:---------------:| :---------------:|
@foreach ($order->products as $product)
| {{ $product->name }} | {{ $product->description }} | {{ $product->pivot->quantity }} | {{ number_format($product->price, 2, ".", ",") }} | {{ number_format($product->price *  $product->pivot->quantity, 2, ".", ",") }} | **MZN** |
@endforeach

<b>Total:</b> {{ number_format($order->order_amount, 2, ".", ",") }} <b>MZN</b><br>
<b>Status: </b> <span style="color: rgb(65, 191, 65)"><b>Paid</b></span>
@endcomponent
{{-- </x-mail::table> --}}
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
