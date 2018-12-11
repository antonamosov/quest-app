<form id="form" action="https://www.sandbox.paypal.com/cgi-bin/websc" method="post">

    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="amosaa-facilitator@mail.ru">
    <input type="hidden" id="paypalItemName" name="item_name" value="{{ $route->name }}">
    <input type="hidden" id="paypalQuantity" name="quantity" value="1">
    <input type="hidden" readonly="readonly" id="paypalAmmount" name="amount" value="{{ $route->price() }}">
    <input type="hidden" name="no_shipping" value="1">
    <input type="hidden" name="return" value="http://play.{{ getenv('DOMAIN') }}.{{ getenv('MAIN_DOMAIN') }}/quest/payment_success?code={{ $code }}">
    <input type="hidden" name="custom" value="{{ $custom }}">
    <input type="hidden" name="currency_code" value="RUB">
    <input type="hidden" name="lc" value="US">
    <input type="hidden" name="bn" value="PP-BuyNowBF">

    <noscript>
        <button  type="submit" class="btn">
            Pay Now
        </button>
    </noscript>


    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <script>
        window.onload = function() {
            document.getElementById('form').submit();
        };
    </script>

</form>