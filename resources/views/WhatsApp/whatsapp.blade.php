@extends('crudbooster::admin_template')
@section('content')
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
    <div style="width: auto; height:100vh">
        <div   id="item-bot" >

            <img src="{{$HostBotWhatsApp}}/qr" alt="" width="200px">

            <div class="column">
                <h3><?php  echo $requireScan ?  "Inactivo":  "Activo" ?></h3>
                <p>Api WhatsApp</p>
                <p>host: {{$HostBotWhatsApp}} </p>


            </div>




        </div>

    </div>

    <script>

        document.getElementsByClassName("content-header")[0].remove();

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
