@extends('admin.layout')

@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <a href="/admin/point"><h3>API</h3><a>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <br>

                        <style>
                            .h4-color {
                                color:#3a8f15;
                            }
                            .h3-color {
                                color: #8f3515;
                            }
                            .json {
                                font-size: 14px;
                                color: green;
                                margin: 3px;
                            }
                            .json-1 {
                                margin-left: 20px;
                            }
                            .json-2 {
                                margin-left: 40px;
                            }
                            .json-3 {
                                margin-left: 60px;
                            }
                            .json-4 {
                                margin-left: 80px;
                            }
                            .json-5 {
                                margin-left: 100px;
                            }
                            .json-6 {
                                margin-left: 120px;
                            }
                            .json-7 {
                                margin-left: 140px;
                            }
                        </style>

                        <p>Данное API предназначено для доступа игры к базе данных.</p>
                        <p>Прошедший авторизацию пользователь попадает на страницу play.{{ getenv('DOMAIN') }}.{{ getenv('MAIN_DOMAIN') }}</p>
                        <p>Основной файл игры необходимо расположить в файле проекта resources/views/showcase/game/index.blade.php. В этот файл передается переменная $code (уникальный код пользователя), которая необхадима для каждого запроса к API.</p>
                        <p>Все остальные файлы игры желательно расположить в папке public/ проекта (корневая директория сайта).</p>
                        <p>Все ответы от сервера API - в формате JSON.</p>
                        <p>В случае успешного запроса возвращаемое значение переменной "success" равно true, в переменной "response" - результаты запроса. В случае неудачи - "success" равно false и в переменной "error" - описание ошибки.</p>

                        <ol>
                            <li><h3 class="h3-color">Получение полного маршрута</h3></li>
                            <p>Для получения полного маршрута (маршрута и текущей точки) необходимо отправить GET запрос на адрес {{ $url }}full-route<strong></strong></p>

                            <h4 class="h4-color">Ожидаемые поля:</h4>
                            <ul>
                                <li><strong>code:</strong> Уникальный код пользователя.</li>

                            </ul>

                            <h4 class="h4-color">Возвращаемые значения:</h4>
                            <ul>
                                <li><strong>route_name</strong> - Название маршрута;</li>
                                <li><strong>count_of_points</strong> - число точек в данном маршруте;</li>
                                <li><strong>current_point</strong> - текущий сохранненый порядковый номер точки (номер точки, до которой до шел пользователь).</li>

                                <li><strong>how_to_get</strong> - как добраться (если нет, false);</li>
                                <li><strong>coordinates</strong> - ссылка на картинку с картой (если нет, false);</li>

                                <li><strong>question_name</strong> - заголовок вопроса;</li>
                                <li><strong>question_paragraph</strong> - пред вопрос (если нет, false);</li>
                                <li><strong>question_question</strong> - вопрос;</li>
                                <li><strong>question_image_path</strong> - путь до изображения для вопроса (если нет, false);</li>
                                <li><strong>hints_01</strong> - подсказка для данной точки (если нет, false);</li>
                                <li><strong>hints_02</strong> - подсказка для данной точки (если нет, false);</li>
                                <li><strong>hints_03</strong> - подсказка для данной точки (если нет, false);</li>

                                <li><strong>btw</strong> - кстати; (если нет, false);</li>
                                <li><strong>btw_image_path</strong> - путь до изображения для "кстати"; (если нет, false);</li>

                                <li><strong>partner_nickname</strong> - имя домена для лэндинга;</li>
                            </ul>

                            <h4 class="h4-color">В случае, если код по каким-то причинам не найден, возвращается код ошибки:</h4>
                            <ul>
                                <li><strong>001</strong> - Код не найден;</li>
                                <li><strong>002</strong> - Нет кода в запросе;</li>
                                <li><strong>003</strong> - Код не найден (не активен);</li>
                                <li><strong>004</strong> - Маршрут пройден;</li>
                                <li><strong>005</strong> - Маршрут удален;</li>
                                <li><strong>006</strong> - Не найден вопрос для текучей точки;</li>
                                <li><strong>007</strong> - Код устарел;</li>
                                <li><strong>008</strong> - Код не оплачен;</li>
                            </ul>

                            <h4 class="h4-color">Тестирование:</h4>
                            <form method="get" action="{{ $url }}full-route" target="_new">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-1">
                                            <label for="code">Код</label>
                                            <input class="form-control" type="text" id="code" name="code" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 col-md-offset-1">
                                        <button class="btn" type="submit">GET</button>
                                    </div>
                                </div>
                            </form>

                            <br><hr>


                            <!-- ------------------------------------------------------------------------------------------------------ -->

                            <li><h3 class="h3-color">Проверка ответа</h3></li>
                            <p>Для проверки ответа необходимо отправить GET запрос на адрес {{ $url }}point/{номер точки}/answer<strong></strong></p>
                            <p>- где номер точки - номер точки в маршруте.</p>
                            <p>В случае совпадения ответа с ответами в базе данных сервер вернет "success" : true, в противном случе - false.</p>

                            <h4 class="h4-color">Ожидаемые поля:</h4>
                            <ul>
                                <li><strong>code:</strong> Уникальный код пользователя;</li>
                                <li><strong>answer:</strong> ответ.</li>
                            </ul>

                            <h4 class="h4-color">Возвращаемые значения:</h4>
                            <ul>
                                <li>Сервер ничего не возвращает, кроме true, false и причины ошибки (error).</li>
                            </ul>

                            <h4 class="h4-color">Тестирование:</h4>
                            <form method="get" id="answer_form" target="_new">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-1">
                                            <label for="code">Код</label>
                                            <input class="form-control" type="text" id="code" name="code" value="{{ old('code') }}" required="required">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-1">
                                            <label for="number">Номер точки</label>
                                            <input class="form-control" type="text" id="number_point_a" value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-1">
                                            <label for="answer">Ответ</label>
                                            <input class="form-control" type="text" name="answer" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 col-md-offset-1">
                                        <button onclick="answerAction(this.form)" class="btn" type="submit">GET</button>
                                    </div>
                                </div>
                                <script>
                                    function answerAction(fa)
                                    {
                                        var aPointNumber = $('#number_point_a').val();
                                        fa.action = '<?php echo $url; ?>' + 'point/' + aPointNumber + '/answer';
                                        fa.submit();
                                    }
                                </script>

                            </form>

                            <br><hr>


                            <!-- ------------------------------------------------------------------------------------------------------ -->

                            <li><h3 class="h3-color">Сброс маршрута</h3></li>
                            <p>Для перезагрузки маршрута (установки текущей точки в "1") необходимо отправить GET запрос на адрес {{ $url }}reset<strong></strong></p>

                            <h4 class="h4-color">Ожидаемые поля:</h4>
                            <ul>
                                <li><strong>code:</strong> Уникальный код пользователя;</li>
                            </ul>

                            <h4 class="h4-color">Возвращаемые значения:</h4>
                            <ul>
                                <li>Сервер ничего не возвращает, кроме true, false.</li>
                            </ul>

                            <h4 class="h4-color">Тестирование:</h4>
                            <form method="get" action="{{ $url }}reset" target="_new">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-1">
                                            <label for="code">Код</label>
                                            <input class="form-control" type="text" id="code" name="code" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 col-md-offset-1">
                                        <button class="btn" type="submit">GET</button>
                                    </div>
                                </div>
                            </form>

                            <br><hr>


                            <!-- ------------------------------------------------------------------------------------------------------ -->

                            <li><h3 class="h3-color">Проверка оплаты кода</h3></li>
                            <p>Для проверки, оплачен код, или нет, необходимо отправить GET запрос на адрес {{ $url }}check_success<strong></strong></p>

                            <h4 class="h4-color">Ожидаемые поля:</h4>
                            <ul>
                                <li><strong>code:</strong> Уникальный код пользователя;</li>
                            </ul>

                            <h4 class="h4-color">Возвращаемые значения:</h4>
                            <ul>
                                <li>Сервер ничего не возвращает, кроме true, false.</li>
                            </ul>

                            <h4 class="h4-color">Тестирование:</h4>
                            <form method="get" action="{{ $url }}check_success" target="_new">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-1">
                                            <label for="code">Код</label>
                                            <input class="form-control" type="text" id="code" name="code" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 col-md-offset-1">
                                        <button class="btn" type="submit">GET</button>
                                    </div>
                                </div>
                            </form>

                            <br><hr>

                            <!-- ------------------------------------------------------------------------------------------------------ -->


                            <li><h3 class="h3-color">Получение маршрута</h3></li>
                            <p>Для получения маршрута необходимо отправить GET запрос на адрес {{ $url }}route<strong></strong></p>

                            <h4 class="h4-color">Ожидаемые поля:</h4>
                            <ul>
                                <li><strong>code:</strong> Уникальный код пользователя.</li>

                            </ul>

                            <h4 class="h4-color">Возвращаемые значения:</h4>
                            <ul>
                                <li><strong>name</strong> - Название маршрута;</li>
                                <li><strong>description</strong> - описание;</li>
                                <li><strong>image_path</strong> - путь к изображению маршрута;</li>
                                <li><strong>count_of_points</strong> - число точек в данном маршруте;</li>
                                <li><strong>current_point</strong> - текущий сохранненый порядковый номер точки (номер точки, до которой до шел пользователь).</li>
                            </ul>

                            <h4 class="h4-color">Тестирование:</h4>
                            <form method="get" action="{{ $url }}route" target="_new">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-1">
                                            <label for="code">Код</label>
                                            <input class="form-control" type="text" id="code" name="code" value="">
                                        </div>
                                    </div>
                                </div>
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-1">
                                            <button class="btn" type="submit">GET</button>
                                        </div>
                                    </div>
                            </form>

                            <br><hr>



                            <!-- ------------------------------------------------------------------------------------------------------ -->

                            <li><h3 class="h3-color">Получение текучей точки пользователя</h3></li>
                            <p>Для получения следующей точки из маршрута необходимо отправить GET запрос на адрес <strong>{{ $url }}route/current</strong></p>
                            <p>В случае, если сервер API вернет success="false", значит, точки закончились и предыдущая была последней.</p>
                            <p>Данная функция, в отличие от последующих двух, позволяет не заботится об подсчете точек, достаточно отправить запрос на сервер, который автоматически определяет текучую точку пользователя в данный момент. Если точки есть для данного маршрута и пользователь еще не прошел всю игру, то сервер вернет точку.</p>

                            <h4 class="h4-color">Ожидаемые поля:</h4>
                            <ul>
                                <li><strong>code:</strong> Уникальный код пользователя.</li>
                            </ul>

                            <h4 class="h4-color">Возвращаемые значения:</h4>
                            <ul>
                                <li><strong>name</strong> - Название точки;</li>
                                <li><strong>coordinates</strong> - ссылка на картинку с картой;</li>
                                <li><strong>how_to_get</strong> - как добраться;</li>
                                <li><strong>btw</strong> - кстати;</li>
                                <li><strong>btw_image_path</strong> - путь до изображения для "кстати";</li>
                                <li><strong>count_of_hints</strong> - число подсказок для данной точки;</li>
                                <li><strong>question_image_path</strong> - путь до изображения для вопроса;</li>
                                <li><strong>question_question</strong> - вопрос;</li>
                                <li><strong>question_paragraph</strong> - пред вопрос;</li>
                                <li><strong>count_of_points</strong> - общее число точек в текучем маршруте;</li>
                                <li><strong>current_point</strong> - порядковый номер данной точки;</li>
                            </ul>

                            <h4 class="h4-color">Тестирование:</h4>
                            <form method="get" action="{{ $url }}point/current" target="_new">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-1">
                                            <label for="code">Код</label>
                                            <input class="form-control" type="text" id="code" name="code" value="{{ old('code') }}" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 col-md-offset-1">
                                        <button class="btn" type="submit">GET</button>
                                    </div>
                                </div>

                            </form>

                            <br><hr>



                            <!-- ------------------------------------------------------------------------------------------------------ -->

                            <li><h3 class="h3-color">Получение точки</h3></li>
                            <p>Для получения точки из маршрута необходимо отправить GET запрос на адрес {{ $url }}route/point/{номер точки}<strong></strong></p>
                            <p>- где номер точки - номер точки в маршруте</p>

                            <h4 class="h4-color">Ожидаемые поля:</h4>
                            <ul>
                                <li><strong>code:</strong> Уникальный код пользователя.</li>
                            </ul>

                            <h4 class="h4-color">Возвращаемые значения:</h4>
                            <ul>
                                <li><strong>name</strong> - Название точки;</li>
                                <li><strong>coordinates</strong> - ссылка на картинку с картой;</li>
                                <li><strong>how_to_get</strong> - как добраться;</li>
                                <li><strong>btw</strong> - кстати;</li>
                                <li><strong>btw_image_path</strong> - путь до изображения для "кстати";</li>
                                <li><strong>count_of_hints</strong> - число подсказок для данной точки;</li>
                                <li><strong>question_image_path</strong> - путь до изображения для вопроса;</li>
                                <li><strong>question_question</strong> - вопрос;</li>
                                <li><strong>question_paragraph</strong> - пред вопрос;</li>
                            </ul>

                            <h4 class="h4-color">Тестирование:</h4>
                            <form method="get" id="point_form" target="_new">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-1">
                                            <label for="code">Код</label>
                                            <input class="form-control" type="text" id="code" name="code" value="{{ old('code') }}" required="required">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-1">
                                            <label for="number">Номер точки</label>
                                            <input class="form-control" type="text" id="number" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 col-md-offset-1">
                                        <button onclick="pointAction(this.form)" class="btn" type="submit">GET</button>
                                    </div>
                                </div>
                                <script>
                                    function pointAction(f)
                                    {
                                        var pointNumber = $('#number').val();
                                        f.action = '<?php echo $url; ?>' + 'route/point/' + pointNumber;
                                        f.submit();
                                    }
                                </script>

                            </form>

                            <br><hr>


                            <!-- ------------------------------------------------------------------------------------------------------ -->

                            <li><h3 class="h3-color">Получение всех точек</h3></li>
                            <p>Для получения всех точек из маршрута необходимо отправить GET запрос на адрес {{ $url }}points<strong></strong></p>
                            <p>- где номер точки - номер точки в маршруте</p>

                            <h4 class="h4-color">Ожидаемые поля:</h4>
                            <ul>
                                <li><strong>code:</strong> Уникальный код пользователя.</li>
                            </ul>

                            <h4 class="h4-color">Возвращаемые значения:</h4>
                            <ul>
                                <li><strong>number</strong> - Порядковый номер точки;</li>
                                <li><strong>name</strong> - Название точки;</li>
                                <li><strong>coordinates</strong> - ссылка на картинку с картой;</li>
                                <li><strong>how_to_get</strong> - как добраться;</li>
                                <li><strong>btw</strong> - кстати;</li>
                                <li><strong>image_path</strong> - путь до изображения;</li>
                                <li><strong>count_of_hints</strong> - число подсказок для данной точки;</li>
                                <li><strong>question_question</strong> - вопрос;</li>
                                <li><strong>question_paragraph</strong> - пред вопрос;</li>
                            </ul>

                            <h4 class="h4-color">Тестирование:</h4>
                            <form method="get" action="{{ $url }}points" target="_new">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-1">
                                            <label for="code">Код</label>
                                            <input class="form-control" type="text" id="code" name="code" value="{{ old('code') }}" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 col-md-offset-1">
                                        <button class="btn" type="submit">GET</button>
                                    </div>
                                </div>


                            </form>

                            <br><hr>



                            <!-- ------------------------------------------------------------------------------------------------------ -->

                            <li><h3 class="h3-color">Получение подсказок</h3></li>
                            <p>Для получения подсказок из точки необходимо отправить GET запрос на адрес {{ $url }}point/{номер точки}/hint/{номер подсказки}<strong></strong></p>
                            <p>- где номер точки - номер точки в маршруте, номер подсказки - номер подскази в точке</p>

                            <h4 class="h4-color">Ожидаемые поля:</h4>
                            <ul>
                                <li><strong>code:</strong> Уникальный код пользователя.</li>
                            </ul>

                            <h4 class="h4-color">Возвращаемые значения:</h4>
                            <ul>
                                <li><strong>name</strong> - подсказка.</li>
                            </ul>

                            <h4 class="h4-color">Тестирование:</h4>
                            <form method="get" id="hint_form" target="_new">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-1">
                                            <label for="code">Код</label>
                                            <input class="form-control" type="text" id="code" name="code" value="{{ old('code') }}" required="required">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-1">
                                            <label for="number">Номер точки</label>
                                            <input class="form-control" type="text" id="number_point" value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-1">
                                            <label for="number_hint">Номер подсказки</label>
                                            <input class="form-control" type="text" id="number_hint" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 col-md-offset-1">
                                        <button onclick="hintAction(this.form)" class="btn" type="submit">GET</button>
                                    </div>
                                </div>
                                <script>
                                    function hintAction(fh)
                                    {
                                        var hPointNumber = $('#number_point').val();
                                        var hHintNumber = $('#number_hint').val();
                                        fh.action = '<?php echo $url; ?>' + 'point/' + hPointNumber + '/hint/' + hHintNumber;
                                        fh.submit();
                                    }
                                </script>

                            </form>



                            <br><hr>

                        </ol>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection