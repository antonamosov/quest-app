<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="myModal_POI_edit_{{ $point->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Edit POI</h4>
            </div>



            <div class="modal-body">

                @if(Session::get('err'))
                    <div class="row">
                        <div class="alert alert-danger" role="alert">
                            {{ trans(Session::get('err')) }}
                        </div>
                    </div>
                @endif
                @if (count($errors) > 0)
                    <div class="row">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form method="post" action="/admin/route/{{ $route->id }}/point/edit/{{ $point->id }}" class="form-horizontal form-label-left" enctype="multipart/form-data">







                    <!-- POI Name -->
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">POI name <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input value="{{ $point->name }}" name="name" type="text" id="name" required="required" class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                        </div>
                    </div>

                    <!-- POI Coordinates in the map -->
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="coordinates"> POI Coordinates in the map
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input placeholder="example: 55.111111, -77.333333" value="{{ $point->coordinates }}" name="coordinates" type="text" id="coordinates_{{ $point->id }}" class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                        </div>
                    </div>

                    <!-- How to get -->
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="how_to_get">Route (How to get to get to this POI)
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea class="form-control" name="how_to_get" id="how_to_get">{{ $point->how_to_get }}</textarea>
                        </div>
                    </div>


                    <!-- Question paragraph (the question description or preamble) -->
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paragraph">Question paragraph (the question description or preamble)
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea class="form-control" name="paragraph" id="paragraph">{{ $point->getQuestionParagraph() }}</textarea>
                        </div>
                    </div>

                    <!-- Question itself -->
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="question">Question itself <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea class="form-control" name="question" id="question">{{ $point->getQuestionName() }}</textarea>
                        </div>
                    </div>





                    <!-- Question Image -->
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Question Image (Max file size: {{ \App\Image::file_upload_max_size() }})
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input value="{{ old('question_image') }}" name="question_image" type="file" id="question_image"  class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                        </div>
                    </div>

                    @if ($point->Question)
                        @if ($point->Question->Image)
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Current image
                                </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <a target="_blank" href="{{ getenv('PUBLIC') }}{{ $point->Question->Image->path }}">{{ $point->Question->Image->name() }}</a>
                                </div>
                            </div>
                        @endif
                    @endif

                    @if ($point->Question)
                        <input type="hidden" value="{{ $point->Question->image_id }}" name="uploaded_question_image_id">
                    @endif



                    <!-- BTW -->
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="btw">BTW
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea class="form-control" name="btw" id="btw">{{ $point->btw }}</textarea>
                        </div>
                    </div>





                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="btw_image">BTW Image (Max file size: {{ \App\Image::file_upload_max_size() }})
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input value="{{ old('btw_image') }}" name="btw_image" type="file" id="btw_image" class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                        </div>
                    </div>

                    @if ($point->Image)
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="btw_image">Current image
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <a target="_blank" href="{{ getenv('PUBLIC') }}{{ $point->Image->path }}">{{ $point->Image->name() }}</a>
                        </div>
                    </div>
                    @endif

                    <input type="hidden" value="{{ $point->image_id }}" name="uploaded_btw_image_id">


                        <!-- Answers-->
                    <?php $j = 1; ?>

                     @if(count($point->answers))
                         @foreach($point->answers as $answer)

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="answer[{{$j}}]"> Answer {{ $j }}
                                    @if($j == 1)
                                        <span class="required">*</span>
                                    @endif
                                </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input value="{{ $answer->name }}" name="answer[{{$j}}]" type="text" id="answer[{{$j}}]"
                                           @if($j == 1)
                                           required="required"
                                           @endif
                                           class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                                </div>
                            </div>

                            <?php $j++; ?>

                         @endforeach
                     @endif



                    @for($i = $j; $i < 6; $i++)

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="answer[{{$i}}]"> Answer {{ $i }}
                                @if($i == 1)
                                    <span class="required">*</span>
                                @endif
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input value="" name="answer[{{$i}}]" type="text" id="answer[{{$i}}]"
                                       @if($i == 1)
                                       required="required"
                                       @endif
                                       class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                            </div>
                        </div>

                        @endfor

                                <!-- Hints  -->
                        <?php $j = 1; ?>

                        @if(count($point->hints))
                            @foreach($point->hints as $hint)

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hint[{{$j}}]"> Hint {{ $j }}                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input value="{{ $hint->name }}" name="hint[{{$j}}]" type="text" id="hint[{{$j}}]" class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                                    </div>
                                </div>

                                <?php $j++; ?>

                            @endforeach
                        @endif

                        @for($i = $j; $i < 4; $i++)


                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hint[{{ $i }}]"> Hint {{ $i }}

                                </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input value="{{ old('hint[]') }}" name="hint[{{ $i }}]" type="text" id="hint[{{ $i }}]" class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                                </div>
                            </div>

                        @endfor



                        <div class="ln_solid"></div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>


                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>