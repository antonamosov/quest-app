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

                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="post">

                                    <h3>For get code enter the email or phone</h3>

                                    <div class="row">
                                        <label for="email">Email</label>
                                        <input id="email" name="email" type="text" size="6">
                                    </div>

                                    <div class="row">
                                        <label for="phone">Phone</label>
                                        <input id="phone" name="phone" type="text" size="6">
                                    </div>

                                    <div class="row">
                                        <button type="submit" class="btn">Submit</button>
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </div>

                                </form>

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
