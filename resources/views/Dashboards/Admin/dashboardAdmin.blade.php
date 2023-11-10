@extends('crudbooster::admin_template')
@section('content')



    <div style="width: auto; height:100vh">
        <div class="contain">
{{--            <span style="margin-left: 50px;margin-top: 10px" class="typingText">Frase del dia.</span>--}}
            <span style="margin: 50px; margin-top: 10px;font-size: 25px !important; color:grey;" class="typingText" >Dservices!</span>

        </div>

        <html>

            <body>

            </body>

        </html>




    </div>




    <script>

        document.getElementsByClassName("content-header")[0].remove();

    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap');
    </style>
    <style>

        .typingText{

            display: block;
            font-family: 'Montserrat', sans-serif;
            /*white-space: nowrap;*/
            /*border-right:  20px solid;*/
            width: 80%;
            /*width: 200px ;*/
            /*animation: typing 1s steps(var(--i)) , blink .5s infinite step-end alternate;*/
            overflow: hidden;
            font-size: 30px;
            color: #1F1F1F;
            font-weight: lighter;

        }

        #content_section{
            background: white;
        }

        @keyframes typing {
            from { width: 0; }
        }

        @keyframes blink {
            50% { border-color: transparent;}
        }

    </style>


    <link rel="stylesheet" href="./css/All.css">

@endsection
