@extends('crudbooster::admin_template')
@section('content')


    <?php

    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $protocolo = 'https';
    } else {
        $protocolo = 'http';
    }

    $url_actual = $protocolo."://" . $_SERVER["SERVER_NAME"] ;
    $back_url = $url_actual."/".$module_name;

    $arg = "";
    if(Request('q') != null){
        $arg = "?q=".Request('q')."&v=".Request('v');
    }


//    dd($arg);
    ?>
    <style>
        /* The switch - the box around the slider */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>

    <link rel="stylesheet" href="./css/All.css">
    <link rel="stylesheet" href="{{$url_actual}}/css/All.css">


    <section class="content-header">
            <h1>
                <!--Now you can define $page_icon alongside $page_tite for custom forms to follow CRUDBooster theme style -->
                <i class="fa fa-list-alt text-normal"></i> Detalles {{$module_name}} &nbsp;&nbsp;

            </h1>


            <ol class="breadcrumb">
                <li><a href="{{$back_url}}{{$arg}}"><i class="fa fa-dashboard"></i> Principal</a></li>
                <li class="active">{{$module_name}}</li>
            </ol>
        </section>


        <!-- Main content -->
        <section id="content_section" class="content">






            <!-- Your Page Content Here -->

            <div>

                <p><a title="Main Module" href="{{$back_url}}{{$arg}}"><i class="fa fa-chevron-circle-left "></i>
                        &nbsp; Volver al listado {{$module_name}}</a></p>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><i class="fa fa-list-alt text-normal"></i> Detalles {{$module_name}}</strong>
                    </div>

                    <div class="panel-body" style="padding:20px 0px 0px 0px">
                        <form class="form-horizontal" method="post" id="form" enctype="multipart/form-data" action="">

                            <div class="box-body" id="parent-form-area">

                                <div class="table-responsive">
                                    <table id="table-detail" class="table table-striped">


                                        <tbody>

                                        @foreach(($indexs) as $item)


                                            @if($columns[$item]['type'] == "select")

                                                    <?php

                                                    $datatSelect = \Illuminate\Support\Facades\DB::connection("mysql");
                                                    $mongo = false;

                                                    $mongo =  $columns[$item]['mongo'];


                                                    if($mongo){
                                                        $datatSelect = \Illuminate\Support\Facades\DB::connection("mongodb");
                                                    }

                                                    $label = explode(",",$columns[$item]['table'])[0];
                                                    $campo_name = explode(",",$columns[$item]['table'])[1];


                                                     $datatSelect = $datatSelect->table($label)->find(((array)$service)[$item]);



                                                    ?>


                                                    @if($columns[$item]['href'])
                                                        <tr>
                                                            <td>{{$columns[$item]['label']}}</td>
                                                            <td><a href="{{$url_actual."/admin/".$columns[$item]['href']."/detail/".((array)$service)[$item]??""}}">{{((array)$datatSelect)[$campo_name]}}</a></td>

                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td>{{$columns[$item]['label']}}</td>
                                                            <td>{{((array)$datatSelect)[$campo_name]}}</td>
                                                        </tr>
                                                    @endif

                                            @else

                                                <tr>
                                                    <td>{{$columns[$item]['label']}}</td>
                                                    <td>{{((array)$service)[$item]}}</td>
                                                </tr>

                                            @endif



                                        @endforeach




                                        </tbody></table>
                                </div>
                            </div><!-- /.box-body -->

                            <div class="box-footer" style="background: #F5F5F5">

                                <div class="form-group">
                                    <label class="control-label col-sm-2"></label>
                                    <div class="col-sm-10">



                                    </div>
                                </div>


                            </div><!-- /.box-footer-->

                        </form>

                    </div>
                </div>
            </div><!--END AUTO MARGIN-->

        </section><!-- /.content -->


    <script>document.getElementsByClassName("content-header")[0].remove();</script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Comfortaa&display=swap');
        *{
            font-family: 'Comfortaa', cursivex;
            font-weight: 500;
        }

        .user-panel{
            margin: 10px;
            padding: 10px;
            /*margin-bottom: 10px;*/
        }

        .img-circle{
            object-fit: cover !important;
            width: 40px !important;
            height: 40px !important;
            box-shadow: 0 5px 15px #a0a0a066;

        }

        .btn{
            border-radius: 15px;
            margin: 2px;
            box-shadow: 0 5px 10px #a0a0a033;
            /*padding: 2px;*/
        }
    </style>

@endsection
