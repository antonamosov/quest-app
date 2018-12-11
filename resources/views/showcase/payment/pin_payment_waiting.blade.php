@extends('showcase.layout')

@section('content')
    <section>


        <div id="quest_prime">

            <div id="quest_area">
                <div class="area">
                    <div class="zone-center">
                        <br><br>
                        <div class="quest_center">
                            <img src="/images/logo-01-1.png" alt="logo">
                            <br><br><br><br><br><br>
                            <br>
                            <div class="quest_div_input">



                            <script>

                                // 1. Wait for the page to load
                                $(function() {

                                // 2. Create an API object with your publishable api key, and
                                // specifying 'test' or 'live'.
                                //
                                // Be sure to use your live publishable key with the live api, and
                                // your test publishable key with the test api.
                                var pinApi = new Pin.Api('your publishable key', 'test');

                                var form = $('form.pin'),
                                submitButton = form.find(":submit"),
                                errorContainer = form.find('.errors'),
                                errorList = errorContainer.find('ul'),
                                errorHeading = errorContainer.find('h3');

                                // 3. Add a submit handler to the form which calls Pin.js to
                                // retrieve a card token, and then add that token to the form and
                                // submit the form to your server.
                                form.submit(function(e) {
                                e.preventDefault();

                                // Clear previous errors
                                errorList.empty();
                                errorHeading.empty();
                                errorContainer.hide();

                                // Disable the submit button to prevent multiple clicks
                                submitButton.attr({disabled: true});

                                // Fetch details required for the createToken call to Pin Payments
                                var card = {
                                number:           $('#cc-number').val(),
                                name:             $('#cc-name').val(),
                                expiry_month:     $('#cc-expiry-month').val(),
                                expiry_year:      $('#cc-expiry-year').val(),
                                cvc:              $('#cc-cvc').val(),
                                address_line1:    $('#address-line1').val(),
                                address_line2:    $('#address-line2').val(),
                                address_city:     $('#address-city').val(),
                                address_state:    $('#address-state').val(),
                                address_postcode: $('#address-postcode').val(),
                                address_country:  $('#address-country').val()
                                };

                                // Request a token for the card from Pin Payments
                                pinApi.createCardToken(card).then(handleSuccess, handleError).done();
                                });

                                function handleSuccess(card) {
                                // Add the card token to the form
                                //
                                // Once you have the card token on your server you can use your
                                // private key and Charges API to charge the credit card.
                                $('<input>')
                                .attr({type: 'hidden', name: 'card_token'})
                                .val(card.token)
                                .appendTo(form);

                                // Resubmit the form to the server
                                //
                                // Only the card_token will be submitted to your server. The
                                // browser ignores the original form inputs because they don't
                                // have their 'name' attribute set.
                                form.get(0).submit();
                                }

                                function handleError(response) {
                                errorHeading.text(response.error_description);

                                if (response.messages) {
                                $.each(response.messages, function(index, paramError) {
                                $('<li>')
                                    .text(paramError.param + ": " + paramError.message)
                                    .appendTo(errorList);
                                    });
                                    }

                                    errorContainer.show();

                                    // Re-enable the submit button
                                    submitButton.removeAttr('disabled');
                                    };
                                    });

                                </script>


                            </div>

                            <br><br><br><br><br><br>
                            <a href="/"><img class="img-link" src="/img/il/i-info-01.png" title="info" alt="info"></a>
                            <br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
