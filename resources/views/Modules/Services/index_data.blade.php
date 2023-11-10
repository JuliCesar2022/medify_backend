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




    ?>
    <link rel="stylesheet" href="../../css/All.css">

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
    <link rel="stylesheet" href="../../../css/All.css">


        <section class="content-header">
            <h1>
                <!--Now you can define $page_icon alongside $page_tite for custom forms to follow CRUDBooster theme style -->
                <i class="fa fa-list-alt text-normal"></i>
                {{$module_name}} &nbsp;&nbsp;

                <a href="./{{$module_name}}/add{{$arg}}" id="btn_add_new_data" class="btn btn-sm btn-success" title="Añadir">
                    <i class="fa fa-plus-circle"></i> Añadir
                </a>

                <!--ADD ACTIon-->
                <!-- END BUTTON -->
            </h1>
            <br>

            @if( Request("success") )
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-info"></i> Hecho, buen trabajo...</h4>
                    ¡Los datos han sido añadidos!
                </div>
            @endif

            <ol class="breadcrumb">
                <li><a href="{{$url_actual}}{{$arg}}"><i class="fa fa-dashboard"></i> Principal</a></li>
                <li class="active">{{$module_name}}</li>
            </ol>
        </section>


        <!-- Main content -->
        <section id="content_section" class="content">






            <!-- Your Page Content Here -->


            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>




            <div class="box">
                <div class="box-header">

                    <div class="box-tools pull-right" style="position: relative;margin-top: -5px;margin-right: -10px">

{{--                        <a style="margin-top:-23px" href="javascript:void(0)" id="btn_advanced_filter" data-url-parameter="" title="Filtros y búsquedas avanzadas" class="btn btn-sm btn-default ">--}}
{{--                            <i class="fa fa-filter"></i> Filtros y Orden--}}
{{--                        </a>--}}

{{--                        <form method="get" style="display:inline-block;width: 260px;" action="./{{$module_name}}">--}}
{{--                            <div class="input-group">--}}
{{--                                <input type="text" name="q" value="" class="form-control input-sm pull-right" placeholder="Buscar">--}}

{{--                                <div class="input-group-btn">--}}
{{--                                    <button type="submit" class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}


{{--                        <form method="get" id="form-limit-paging" style="display:inline-block" action="./{{$module_name}}{{$arg}}">--}}

{{--                            <div class="input-group">--}}
{{--                                <select onchange="$('#form-limit-paging').submit()" name="limit" style="width: 56px;" class="form-control input-sm">--}}
{{--                                    <option value="5">5</option>--}}
{{--                                    <option value="10">10</option>--}}
{{--                                    <option selected="" value="20">20</option>--}}
{{--                                    <option value="25">25</option>--}}
{{--                                    <option value="50">50</option>--}}
{{--                                    <option value="100">100</option>--}}
{{--                                    <option value="200">200</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </form>--}}

                    </div>

                    <br style="clear:both">

                </div>
                <div class="box-body table-responsive no-padding">
                    <form id="form-table">

                        <table id="table_dashboard" class="table table-hover table-striped table-bordered">
                            <thead>
                            <tr class="active">
                                @foreach($indexs as $item)
                                    <th width="auto"><a href="" title="Click to sort ascending">{{$columns[$item]['label']}} &nbsp; <i class="fa fa-sort"></i></a></th>
                                @endforeach

                                <th width="auto" style="text-align:right">Acción</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if(count($services) == 0)

                                <tr class="warning">
                                    <td colspan="8" align="center">
                                        <i class="fa fa-search"></i> No tenemos datos disponibles
                                    </td>
                                </tr>

                            @endif

                            @foreach($services as $item)
                                <tr>
                                    @foreach($indexs as $item2)

                                        @if($columns[$item2]['type'] == "select")

                                                <?php

                                                        $datatSelect = \Illuminate\Support\Facades\DB::connection("mysql");
                                                        $mongo = false;

                                                        $mongo =  $columns[$item2]['mongo'];


                                                        if($mongo){
                                                            $datatSelect = \Illuminate\Support\Facades\DB::connection("mongodb");
                                                        }

                                                        $label = explode(",",$columns[$item2]['table'])[0];
                                                        $campo_name = explode(",",$columns[$item2]['table'])[1];


                                                        $datatSelect = $datatSelect->table($label)->find($item->toArray()[$item2]);


                                                ?>

                                            @if($columns[$item2]['href'])
                                                <td><a href="{{$url_actual."/admin/".$columns[$item2]['href']."/detail/".$item->toArray()[$item2]??""}}">{{((array)$datatSelect)[$campo_name]}}</a></td>
                                            @else
                                                <td><p>{{((array)$datatSelect)[$campo_name]}}</p></td>
                                            @endif


                                       @elseif( $columns[$item2]['type'] == "money" )
                                            <td>{{'$ ' . number_format($item->toArray()[$item2]??0,0, ',', '.') }}</td>
                                       @else
                                            <td>{{$item->toArray()[$item2]??""}}</td>
                                       @endif

                                    @endforeach




                                    <td>

                                    <div class="button_action" style="text-align:right"><input onclick="window.location = './{{$module_name}}/detail/{{$item->toArray()["_id"]}}{{$arg}}' "  type="button" value="ver" class="btn btn-xs btn-info">  </div>
                                    <div class="button_action" style="text-align:right"><input onclick="window.location = './{{$module_name}}/edit/{{$item->toArray()["_id"]}}{{$arg}}' "  type="button" value="Editar" class="btn btn-xs btn-success">  </div>
                                    <div class="button_action" style="text-align:right"><input onclick=" Swal.fire({
                                          icon: 'info',
                                          title: '¿Estas seguro?',
                                          showDenyButton: true,
                                          confirmButtonText: 'Si',
                                          denyButtonText: `No`,
                                        }).then((result) => {
                                          /* Read more about isConfirmed, isDenied below */
                                          if (result.isConfirmed) {
                                            window.location = './{{$module_name}}/delete/{{$item->toArray()["_id"]}}{{$arg}}'
                                          }
                                        })

                                        "  type="button" value="Eliminar" class="btn btn-xs btn-danger">  </div>


                                        @foreach($buttoms??[] as $a)

                                            @if($a['type'] == "filtter")

                                                <div class="button_action" style="text-align:right"><input onclick="window.location = './{{$a['url']}}?q={{$a['q']}}&v={{$item->toArray()["_id"]}}' "  type="button" value="{{$a['label']}}" class="btn btn-xs btn-success">  </div>

                                            @endif

                                            @if($a['type'] == "function")

                                                <div class="button_action" style="text-align:right"><input onclick="window.location = './{{$module_name}}/function/{{$a['url']}}/{{$item->toArray()["_id"]}}' "  type="button" value="{{$a['label']}}" class="btn btn-xs btn-success">  </div>

                                            @endif



                                        @endforeach



                                    </td>


                                </tr>
                            @endforeach



                            </tbody>


                            <tfoot>
                            <tr>

                                @foreach($indexs as $item)
                                    <th width="auto"><a href="" title="Click to sort ascending">{{$columns[$item]['label']}} &nbsp; <i class="fa fa-sort"></i></a></th>
                                @endforeach

                                <th> - </th>
                            </tr>
                            </tfoot>
                        </table>

                    </form><!--END FORM TABLE-->

                    <div class="col-md-8">
                        <div class="flex justify-between flex-1 sm:hidden" style="margin-left: 60px; position:relative; bottom: 0;">
                            <div onclick="addParameterInUrl('page', {{Request()->page??1}} - 1 )" class="btn btn-sm btn-default" style="border-radius: 15px 0px 0px 15px !important; margin:3px; ">
                                « Previous
                            </div><p class="btn btn-sm btn-default" style="border-radius: 0 !important; margin-left:5px">{{Request()->page??1}}</p>

                            <div class="btn btn-sm btn-default" onclick="addParameterInUrl('page', {{Request()->page??1}} + 1 )" style="border-radius: 0px 15px 15px 0px !important; margin:3px; ">
                                Next »
                            </div>
                        </div>


                    </div>
                    <div class="col-md-4"><span class="pull-right">Total de registros
        : 1 a 1 de 1</span></div>

                </div>
            </div>


        </section><!-- /.content -->
{{--    </div>--}}


    <script>document.getElementsByClassName("content-header")[0].remove();</script>

    <style>

        .column{
            display: flex;
            flex-direction: column;

        }

        #item-bot{
            width: 100%;
            height: 300px;
            /*background: red;*/
            display: flex;
            justify-content: start;
            align-items: center;
            gap: 20px;
            padding-left: 50px;
            border: solid 1.5px #3c763d;
            border-radius: 10px;
            box-shadow: 10px 0px 10px rgba(0,0,0,.2);
            background: white;

        }

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

    <script>
        function addParameterInUrl(name, value) {
            const urlParams = new URLSearchParams(window.location.search);

            // Si el parámetro ya existe, se modifica su valor
            if (urlParams.has(name)) {
                urlParams.set(name, value);
            } else {
                // Si el parámetro no existe, se agrega
                urlParams.append(name, value);
            }

            // Se construye la nueva URL con los parámetros modificados/agregados
            const newUrl = `${window.location.origin}${window.location.pathname}?${urlParams.toString()}${window.location.hash}`;

            // Se redirige a la nueva URL
            window.location.href = newUrl;
        }
        function isFirst(href){
            if(Object.entries(getAllUrlParams(href)).length == 0){
                return true;
            }else{
                return false
            }
        }

        function getAllUrlParams(url) {
            var queryString = url ? url.split('?')[1] : window.location.search.slice(1);
            var obj = {};
            if (queryString) {
                queryString = queryString.split('#')[0];
                var arr = queryString.split('&');
                for (var i = 0; i < arr.length; i++) {
                    var a = arr[i].split('=');
                    var paramName = a[0];
                    var paramValue = typeof (a[1]) === 'undefined' ? true : a[1];
                    paramName = paramName.toLowerCase();
                    if (typeof paramValue === 'string') paramValue = paramValue;
                    if (paramName.match(/\[(\d+)?\]$/)) {
                        var key = paramName.replace(/\[(\d+)?\]/, '');
                        if (!obj[key]) obj[key] = [];
                        if (paramName.match(/\[\d+\]$/)) {
                            var index = /\[(\d+)\]/.exec(paramName)[1];
                            obj[key][index] = paramValue;
                        } else {
                            obj[key].push(paramValue);
                        }
                    } else {
                        if (!obj[paramName]) {
                            obj[paramName] = paramValue;
                        } else if (obj[paramName] && typeof obj[paramName] === 'string'){
                            obj[paramName] = [obj[paramName]];
                            obj[paramName].push(paramValue);
                        } else {
                            obj[paramName].push(paramValue);
                        }
                    }
                }
            }

            return obj;
        }
    </script>

@endsection
