@extends('crudbooster::admin_template')
@section('content')



    <div style="width: auto; height:100vh">
        <div class="contain">
            <span style="margin: 50px; margin-top: 10px;font-size: 25px !important; color:grey;" class="typingText" >Cartera!</span>
        </div>

        <html>

        <div style="margin-left: 60px">


          <div class="head-all" style="display: flex;">
              <div class="header-box-wallet" style="display: flex;">
                  <div class="user" style="margin: 20px; display: flex; flex-direction: column; justify-content: center;align-items: center;text-align: center;">
                      <img style="border-radius: 100px;width: 100px;" src="https://picsum.photos/200" alt="">
                      <h2>{{$user->name." ".$user->last_name}}</h2>
                  </div>

                  <div class="saldo" style="margin: 20px;">
                      <h1 style="color: #00a157">${{number_format($wallet->current_amount)}}</h1>
                      <form method="GET" action="/make-moviment" style="margin: 0px;">

                          <input type="hidden" name="user_id" value="{{$user->id}}">
                          <div class="input-container">
                              <span class="input-symbol">$</span>
                              <input type="number" id="cantidad" name="cantidad" step="0.01" min="0" required class="input-cantidad">
                          </div>
                          <br>

                          <div class="input-container">
                              <span class="input-symbol">#</span>
                              <input type="text" id="cantidad" name="rason" required class="input-cantidad" placeholder="rason">
                          </div>
                          <div class="botones-container">
                              <button type="submit" name="accion" value="IN" class="boton-recargar">Recargar</button>

                              <button type="submit" name="accion" value="OUT" class="boton-retirar">Retirar</button>
                          </div>
                      </form>
                  </div>
              </div>




          </div>

            <hr>
           <div class="moviments-wallet" style="overflow-x: auto; height: 50vh">
               @foreach($moviments as $m)

                   <div class="moviment">
                       <p>{{ $m->reason }}</p>
                       <p style="color: #00a157">${{number_format($m->amount)}}</p>
                       <p style="color: {{ $m->type =="OUT"?"red":"green"}};" > {{ $m->type }}</p>
                       <p>{{ $m->created_at }}</p>
                   </div>

                   <hr>
               @endforeach
           </div>

{{--         <img src="../../../storage/{{$user->photo_profile }}" alt="">--}}
        </div>

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

        .formulario {
            width: 400px;
            margin: 0 auto;
            font-family: Arial, sans-serif;
        }

        .label-cantidad {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .input-container {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 6px;
        }

        .input-cantidad {
            flex: 1;
            border: none;
            outline: none;
            font-size: 16px;
        }

        .input-symbol {
            font-size: 16px;
            margin-right: 6px;
        }

        .botones-container {
            margin-top: 10px;
        }

        .boton-recargar, .boton-retirar {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-right: 10px;
            cursor: pointer;
            border-radius: 10px !important;
        }

        .boton-retirar{
            background: red;
        }
        .boton-retirar:hover {
            background: darkred;

        }

        .boton-recargar:hover  {
            background-color: #3E8E41;
        }
    </style>


    <link rel="stylesheet" href="../../../css/All.css">

@endsection
