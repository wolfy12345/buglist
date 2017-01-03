@extends('common.layout')

@section('css')
    <link rel="stylesheet" href="{{asset('assets/js/vendor/summernote/css/summernote.css')}}">
    <link rel="stylesheet" href="{{asset('assets/js/vendor/summernote/css/summernote-bs3.css')}}">
    <link rel="stylesheet" href="{{asset('assets/js/vendor/chosen/css/chosen.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/js/vendor/chosen/css/chosen-bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('assets/js/vendor/datepicker/css/bootstrap-datetimepicker.css')}}">
    <link rel="stylesheet" href="{{asset('assets/js/vendor/colorpicker/css/bootstrap-colorpicker.css')}}">
    <link rel="stylesheet" href="{{asset('assets/js/vendor/colorpalette/bootstrap-colorpalette.css')}}">
@endsection

@section('title', 'BugList')

@section('breadcrumb')
    <li>You are here</li>
    <li><a href="/bug">BugList</a></li>
    <li class="active">Bugs</li>
@endsection

@section('content')
    <section class="tile color transparent-black">
        <!-- tile header -->
        <div class="tile-header">
            <h1><strong>查看</strong> Bug</h1>
            <div class="controls">
                <a href="#" class="refresh"><i class="fa fa-refresh"></i></a>
                <a href="#" class="remove"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <!-- /tile header -->

        <!-- tile body -->
        <div class="tile-body">
            <form class="form-horizontal" role="form">
                {{csrf_field()}}
                <input type="hidden" name="id" value="{{$bug->id}}">
                <div class="form-group">
                    <label for="input01" class="col-sm-2 control-label">页面URL地址</label>
                    <div class="col-sm-10">
                        <input readonly value="{{$bug->url}}" type="text" class="form-control" id="input01">
                    </div>
                </div>

                <div class="form-group">
                    <label for="input02" class="col-sm-2 control-label">标题</label>
                    <div class="col-sm-10">
                        <input readonly value="{{$bug->title}}" type="text" class="form-control" id="input02">
                    </div>
                </div>

                <div class="form-group">
                    <label for="input03" class="col-sm-2 control-label">内容</label>
                    <div class="col-sm-10">
                        <textarea readonly class="form-control" id="input03" rows="10">{{$bug->description}}
                        </textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="input04" class="col-sm-2 control-label">图片</label>
                    <div class="col-sm-10">
                        <img src="{{$bug->images}}" width="150" height="100" class="img-rounded" data-toggle="modal" data-target="#myModal">
                        <span>点击图片可以查看大图</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="input05" class="col-sm-2 control-label">指定修复者</label>
                    <div class="col-sm-10">
                        <input readonly value="{{$bug->fixer->name}}" type="text" class="form-control" id="input02">
                    </div>
                </div>

                <div class="form-group">
                    <label for="input100" class="col-sm-2 control-label">bug状态</label>
                    <div class="col-sm-10">
                        <input readonly value="@if($bug->status==2) 已修复 @elseif($bug->status==1) 激活 @else 已关闭 @endif" type="text" class="form-control" id="input02">
                    </div>
                </div>
            </form>
        </div>
        <!-- /tile body -->
    </section>
@endsection

@include('bug.image_modal')

@section('js')

    <script src="{{asset('assets/js/vendor/summernote/summernote.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/chosen/chosen.jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/momentjs/moment-with-langs.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/datepicker/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/colorpicker/bootstrap-colorpicker.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/colorpalette/bootstrap-colorpalette.js')}}"></script>
    <script src="{{asset('assets/js/minimal.min.js')}}"></script>
    <script>
        //initialize file upload button function
        $(document)
                .on('change', '.btn-file :file', function() {
                    var input = $(this),
                            numFiles = input.get(0).files ? input.get(0).files.length : 1,
                            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                    input.trigger('fileselect', [numFiles, label]);
                });


        $(function(){

            //load wysiwyg editor
            $('#input06').summernote({
                toolbar: [
                    //['style', ['style']], // no style button
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    //['insert', ['picture', 'link']], // no insert buttons
                    //['table', ['table']], // no table button
                    //['help', ['help']] //no help button
                ],
                height: 137   //set editable area's height
            });

            //chosen select input
            $(".chosen-select").chosen({disable_search_threshold: 10});

            //initialize datepicker
            $('#datepicker').datetimepicker({
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                }
            });

            $("#datepicker").on("dp.show",function (e) {
                var newtop = $('.bootstrap-datetimepicker-widget').position().top - 45;
                $('.bootstrap-datetimepicker-widget').css('top', newtop + 'px');
            });

            //initialize colorpicker
            $('#colorpicker').colorpicker();

            $('#colorpicker').colorpicker().on('showPicker', function(e){
                var newtop = $('.dropdown-menu.colorpicker.colorpicker-visible').position().top - 45;
                $('.dropdown-menu.colorpicker.colorpicker-visible').css('top', newtop + 'px');
            });

            //initialize colorpicker RGB
            $('#colorpicker-rgb').colorpicker({
                format: 'rgb'
            });

            $('#colorpicker-rgb').colorpicker().on('showPicker', function(e){
                var newtop = $('.dropdown-menu.colorpicker.colorpicker-visible').position().top - 45;
                $('.dropdown-menu.colorpicker.colorpicker-visible').css('top', newtop + 'px');
            });

            //initialize file upload button
            $('.btn-file :file').on('fileselect', function(event, numFiles, label) {

                var input = $(this).parents('.input-group').find(':text'),
                        log = numFiles > 1 ? numFiles + ' files selected' : label;

                console.log(log);

                if( input.length ) {
                    input.val(log);
                } else {
                    if( log ) alert(log);
                }

            });

            // Initialize colorpalette
            $('#event-colorpalette').colorPalette({
                colors:[['#428bca', '#5cb85c', '#5bc0de', '#f0ad4e' ,'#d9534f', '#ff4a43', '#22beef', '#a2d200', '#ffc100', '#cd97eb', '#16a085', '#FF0066', '#A40778', '#1693A5']]
            }).on('selectColor', function(e) {
                var data = $(this).data();

                $(data.returnColor).val(e.color);
                $(this).parents(".input-group").css("border-bottom-color", e.color );
            });

        })

    </script>
@endsection