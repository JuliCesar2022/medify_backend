@extends('crudbooster::admin_template')
@section('content')

    <?php

    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $protocolo = 'https';
    } else {
        $protocolo = 'http';
    }

    $url_actual = $protocolo . "://" . $_SERVER["SERVER_NAME"];
    $back_url = $url_actual . "/" . $module_name;

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

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
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

    <link rel="stylesheet" href="{{$url_actual}}/css/All.css">


    {{--    <div class="content-wrapper" style="min-height: 830px;">--}}

    <section class="content-header">
        <h1>
            <!--Now you can define $page_icon alongside $page_tite for custom forms to follow CRUDBooster theme style -->
            <i class="fa fa-list-alt text-normal"></i> Añadir {{$module_name}} &nbsp;&nbsp;

        </h1>


        <ol class="breadcrumb">
            <li><a href="{{$back_url}}{{$arg}}"><i class="fa fa-dashboard"></i> Principal </a></li>
            <li class="active">{{$module_name}}</li>
        </ol>
    </section>


    <!-- Main content -->
    <section id="content_section" class="content">

        <!-- Your Page Content Here -->
        <div>

            <p><a title="Return" href="{{$back_url}}{{$arg}}"><i class="fa fa-chevron-circle-left "></i>
                    &nbsp; Volver al listado de {{ $module_name }}</a></p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong><i class="fa fa-users"></i> Añadir {{$module_name}}</strong>
                </div>


                <div class="panel-body" style="padding:20px 0px 0px 0px">
                    <form class="form-horizontal" method="get" id="form" enctype="multipart/form-data"
                          action="{{$update?"./../save":"./save"}}">

                        @if( Request('q') )
                            <input type="hidden" name="q" value="{{Request('q')}}">
                            <input type="hidden" name="v" value="{{Request('v')}}">
                        @endif
                        @foreach(array_keys($indexs) as $item)

                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" id="form-group-name"
                                 style="display:grid;max-width: 450px!important;min-width:450px!important;padding:0px;margin: 10px;margin-block-end: auto!important;background:#F5F5F5;border-radius:15px;">
                                <label class="control-label col-sm-2" style="width: fit-content; margin: 0.25px;">
                                    {{$columns[$item]['label']}}
                                </label>



                                <div class="col-sm-10">


                                    @if($columns[$item]['type'] == "select")

                                            <?php

                                            $datatSelect = \Illuminate\Support\Facades\DB::connection("mysql");
                                            $mongo = false;

                                            $mongo = $columns[$item]['mongo'];

                                            if ($mongo) {
                                                $datatSelect = \Illuminate\Support\Facades\DB::connection("mongodb");
                                            }

                                            $label = explode(",", $columns[$item]['table'])[0];

                                            $datatSelect = $datatSelect->table($label);

                                            if( Request('q') == $item ) {

                                                $datatSelect = $datatSelect->where($mongo?"_id":"id",Request('v'));

                                            }

                                            $datatSelect = $datatSelect->get()->toArray();

                                            ?>

                                        <select
                                            style="border-radius: 100px!important;width: 100%;  height: 30px!important;"
                                            class="select-2" id="{{$item}}" title="Name"
                                            {{$columns[$item]['required'] ? "required" :""}}   class="form-control"
                                            name="{{$item}}" id="name">
                                            <option value="0"> Seleccione {{$columns[$item]['label']}} </option>


                                            @foreach($datatSelect as $item3)

                                                    <?php


                                                    $array = (array)$item3;
                                                    $id = $array["id"] ?? $array["_id"];
                                                    ?>

                                                <option value="{{$id}}" {{$id == $indexs[$item] ? "selected": ""}} <?php echo Request('q')?"selected":"" ?>  >{{ $array[ trim(explode(",",$columns[$item]['table'])[1]) ] }}</option>

                                            @endforeach

                                        </select>

                                    @elseif( $columns[$item]['type'] == "enum" )

                                        <select
                                            style="border-radius: 100px!important;width: 100%;  height: 30px!important;"
                                            class="select-2" id="{{$item}}" title="Name"
                                            {{$columns[$item]['required'] ? "required" :""}}   class="form-control"
                                            name="{{$item}}" id="name">

                                            <option value="0"> Seleccione {{$columns[$item]['label']}} </option>

                                            @foreach($columns[$item]['data'] as $item3)

                                                <option
                                                    value="{{$item3}}" {{$item3 == $indexs[$item] ? "selected": ""}} >{{ $item3 }}</option>

                                            @endforeach

                                        </select>

                                        @elseif( $columns[$item]['type'] == "enum2" )

                                        <select
                                            style="border-radius: 100px!important;width: 100%;  height: 30px!important;"
                                            class="select-2" id="{{$item}}" title="Name"
                                            {{$columns[$item]['required'] ? "required" :""}}   class="form-control"
                                            name="{{$item}}" id="name">



                                            @foreach($columns[$item]['data'] as $i => $item3)
                                                <?php echo '<script> console.log(" '.$i.' - '.$columns[$item]['label'].' - '.$item3.' - '.intval($columns[$item]['datav'][$i]).' - '.intval($indexs[$item]).'") </script>' ?>
                                                <option
                                                    value="{{$columns[$item]['datav'][$i] }}"  {{intval($columns[$item]['datav'][$i]) == intval($indexs[$item]) ? "selected": ""}} >{{ $item3 }}</option>

                                            @endforeach

                                        </select>

                                    @elseif($columns[$item]['type'] == "textarea")

                                        <div class="col-sm-10">
                                            <textarea name="{{$item}}"
                                                      {{$columns[$item]['required'] ? "required" :""}} id="desciption"
                                                      required="" maxlength="5000" class="form-control"
                                                      rows="5">{{$indexs[$item]}}</textarea>
                                            <div class="text-danger"></div>
                                            <p class="help-block"></p>
                                        </div>

                                    @elseif($columns[$item]['type'] == "money")

                                        <input class="money" type="text" name="{{$item}}"
                                               {{$columns[$item]['required'] ? "required" :""}} value="{{$indexs[$item]}}"/>

                                    @else
                                        <input type="{{$columns[$item]['type']}}" title="Name"
                                               {{$columns[$item]['required'] ? "required" :""}}   placeholder=""
                                               maxlength="70" class="form-control" name="{{$item}}" id="name"
                                               value="{{$indexs[$item]}}">
                                    @endif



                                    <div class="text-danger"></div>
                                    <p class="help-block"></p>
                                </div>
                            </div>

                    @endforeach

                </div>

                <div class="box-footer" style="background: #F5F5F5">

                    <div class="form-group">
                        <label class="control-label col-sm-2"></label>
                        <div class="col-sm-10">
                            <a href="{{$back_url}}{{$arg}}" class="btn btn-default"> <i class="fa fa-chevron-circle-left"></i>
                                Volver</a>


                                    @if($update)
                                        <input type="hidden" name="update_one" value="{{$update}}">
                                        <input type="submit" name="submit" value="Guardar" class="btn btn-success">
                                    @else
                                        <input type="submit" name="submit" value="Agregar" class="btn btn-success">
                                    @endif


                                    </div>
                                </div>


                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js">


    </script>

    <script>
        $('.select-2 ').select2();
        console.log("haollaaa")
    </script>

    <style>

        .select-2{
            height: 30px!important;
        }
        .money {
            number-format: col.co;
            width: 100%; border-radius: 100px !important;
            border: solid 1px darkgrey;
            height: 30px;
            outline: none;
            padding-left: 10px;
        }
        .money:focus{
            border: solid 1px steelblue;
        }
    </style>


    <script>document.getElementsByClassName("content-header")[0].remove();</script>
    <script>

        const moneyFields = document.querySelectorAll('.money');

        moneyFields.forEach(function(field) {
            field.addEventListener('input', function() {

                let value = this.value;
                // Remover TODOS los puntos
                value = value.replace(/\D/g, '');
                // Formatear solo si el valor contiene 3 o más dígitos
                if (value.length >= 3) {
                    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                }
                this.value = value;

            });
        });

    </script>


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

@endsection
