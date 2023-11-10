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




    <style>



        h1 {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .col_cs {
            display: flex;
            flex-direction: column;
        }

        .row_cs {
            /* background-color: red; */
            display: flex;


        }

        .from_cs {
            /* background-color: blue; */
            display: flex;
            flex: 5;

        }

        .replaceable_words{
            /* background-color: black; */
            border-color: black;
            display: flex;
            flex: 3;



        }

        .variables_cs{

            border-color: black;
            display: flex;

            /* flex-direction: column; */
            gap: 10px;
            /* color: white; */
            font-weight: 500;
            flex-wrap: wrap;
            max-height: 200px;

        }

        .word_copy{
            cursor: pointer;
            display: flex;
            flex-direction: column;
            /*background: red;*/
            /* width: 400px; */
            justify-content: center;
            align-items: center;
            background: rgba(0, 0,0,.5);
            border-radius: 10px;
            padding-left: 20px;
            padding-right: 20px;
            max-height: 50px;
        }


        .hidden{
            opacity: 0;
            visibility: hidden;
            display: none;
        }


        .from_cs {
            flex: 5;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            /* box-shadow: 0px 0px 3px rgba(0,0,0,.2); */
            padding: 5px;
            /* border-top: rgba(0,0,0,.2) solid 2px; */
        }

        .replaceable_words {
            flex-direction: column;
            flex: 3;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            /* box-shadow: 0 2px 4px rgba(0,0,0,0.1); */
            margin-left: 20px;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        input,
        select,
        textarea {
            /* width: 100%; */
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 16px;
            outline: none;
            transition: 0.2s;

        }

        input:focus,
        select:focus,
        textarea:focus {
            border: 1px solid green;
            transition: 0.5s;
        }

        label{
            background-color: rgba(0,0,0,.05);
            border-radius: 5px;
            padding: 10px;
            margin: 0;
        }

        input{
            margin-right: 10px;
            outline: none;
        }

        .word_copy {
            background: #f7f7f7;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .word_copy p {
            margin: 0;
            display: flex;
            align-items: center;
        }

        .word_copy ion-icon {
            margin-left: 10px;
            font-size: 18px;
            cursor: pointer;

            transition: 0.2s;

        }

        textarea{
            resize: none;
            outline: none;

        }

        /* Pantallas estrechas (móvil) */
        @media (max-width: 1000px) {
            .row_cs {
                flex-direction: column;
            }

            .replaceable_words{
                margin-top: 10px;
                margin-left: 0;
                flex-direction: column;
            }
        }

        .selected{
            background:  rgb(60,141,188);
            color: #fff;
            transition: 0.2s;
        }

        #add_notify{
            padding-top: 20px;
            padding-bottom: 20px;
            border: 1px solid green;
            background-color: white;
            color: green;
            transition: 0.2s;
            border-radius: 5px;
        }

        #add_notify:hover{
            border: 1px solid white;
            background-color: green;
            color: #ddd;
            transition: 0.2s;
            cursor: pointer;
        }

        #add_notify:active{
            opacity: .6;
            transition: 0.2s;
            transform: scale(.99);
        }
    </style>
</head>

<body>

<div class="col_cs">

    <h1> Notificaciones programas </h1>
    <div class="row_cs">

        <div class="from_cs">

            <form action="" method="post" style="width: 100%;padding: 20px;">



                <div class="from_cs" style="width: 100%;">
                    <div class="col_cs" style="width:100%;">
                        <label style="padding-left: 9px;" for="">Notificacion</label>
                        <br>

                        <textarea rows="1" oninput="expandTextArea('title_notify')" id="title_notify"
                                  style="padding: 15px;" type="text" placeholder="Titulo de la notificacion"></textarea>

                        <br>

                        <textarea rows="1" oninput="expandTextArea('body_notify')" id="body_notify"
                                  style="padding: 15px; " type="text"
                                  placeholder="Descripcion de la notificacion"></textarea>

                    </div>
                </div>

                <br>
                <br>

                <div class="from_cs" style="width: 100%;">

                    <div class="col_cs" style="width:100%;">
                        <label style="padding-left: 9px;" for="">Pais</label>

                        <br>

                        <select name="hour" style="padding: 15px;margin: 5px;" id="select_countries"  onchange="handleChangeCountrie()">

                        </select>
                    </div>

                </div>
                <br>

                <div class="from_cs" style="width: 100%;">
                    <div class="col_cs" style="width:100%;">

                        <label style="padding-left: 9px;" for="">Periodico</label>
                        <br>

                        <select name="hour" style="padding: 15px;margin: 5px;" id="unique_select"
                                onchange="handleChangeUnique()">
                            <option value="0">Si</option>
                            <option value="1">No</option>
                        </select>
                    </div>
                </div>

                <br>

                <div class="from_cs" style="width: 100%;" id="unique_select_contain">
                    <div class="col_cs" style="width:100%;">
                        <label style="padding-left: 9px;" for="">Dia</label>
                        <br>

                        <select name="hour" style="padding: 15px;margin: 5px;" id="week_day_select"
                                onchange="handleChangeWeekDay()">
                            <option value="">Todos los dias</option>
                            <option value="0">Lunes</option>
                            <option value="1">Martes</option>
                            <option value="2">Miércoles</option>
                            <option value="3">Jueves</option>
                            <option value="4">Viernes</option>
                            <option value="5">Sábado</option>
                            <option value="6">Domingo</option>
                        </select>
                    </div>
                </div>

                <div class="from_cs hidden" style="width: 100%;"  id="unique">
                    <div class="col_cs " style="width:100%;">

                        <label style="padding-left: 9px;" for="">Fecha</label>
                        <br>

                        <input type="date" style="padding: 15px;margin: 5px;height: 20px;" name="fecha" id="date_notify"
                               placeholder="0">

                    </div>
                </div>



                <br>

                <div class="from_cs" style="width: 100%;">

                    <div class="col_cs" style="width:100%;">
                        <label style="padding-left: 9px;" for="">Hora en Formato 24h</label>

                        <br>

                        <select name="hour" style="padding: 15px;margin: 5px;" id="hour_selected">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                        </select>
                    </div>

                </div>

                <br>


                <div class="from_cs" style="width: 100%;">

                    <div class="col_cs" style="width:100%;">

                        <label style="padding-left: 9px; " for="">Delay en segundos</label>
                        <br>

                        <input type="text" style="padding: 15px;margin: 5px;height: 20px;" name="Hora" id="delay_seconds"
                               placeholder="0">

                    </div>
                </div>



            </form>

        </div>


        <div class="replaceable_words from_cs">

            <div class="col_cs from_cs">

                <label style="padd99-left: 9px;" for="">Variables</label>


                <div class="variables_cs" style="width: 100%;padding: 20px;margin: 5px;">

                    <div class="word_copy" onclick="copiarTexto('1')" >
                        <p id="wallet"><span id="1">$[user_name];</span> <ion-icon
                                name="copy-outline"></ion-icon></p>
                    </div>

                    <div class="word_copy" onclick="copiarTexto('2')" >
                        <p id="wallet"><span id="2">$[user_last_name];</span> <ion-icon
                                name="copy-outline"></ion-icon></p>
                    </div>

                    <div class="word_copy" onclick="copiarTexto('3')" >
                        <p id="wallet"><span id="3">$[user_number_document];</span> <ion-icon
                                name="copy-outline"></ion-icon></p>
                    </div>

                    <div class="word_copy" onclick="copiarTexto('4')" >
                        <p id="wallet"><span id="4">$[user_email];</span> <ion-icon
                                name="copy-outline"></ion-icon></p>
                    </div>

                    <div class="word_copy" onclick="copiarTexto('5')" >
                        <p id="wallet"><span id="5">$[user_country_code];</span> <ion-icon
                                name="copy-outline"></ion-icon></p>
                    </div>

                    <div class="word_copy" onclick="copiarTexto('6')" >
                        <p id="wallet"><span id="6">$[user_phone];</span> <ion-icon
                                name="copy-outline"></ion-icon></p>
                    </div>

                    <div class="word_copy" onclick="copiarTexto('7')"  >
                        <p id="wallet"><span id="7">$[user_birthday];</span> <ion-icon
                                name="copy-outline"></ion-icon></p>
                    </div>

                    <div class="word_copy" onclick="copiarTexto('8')" >
                        <p id="wallet"><span id="8">$[dayWeekName];</span> <ion-icon
                                name="copy-outline"></ion-icon></p>
                    </div>

                </div>

            </div>


            <div class="col_cs from_cs">

                <label style="padd99-left: 9px;" for="">Filtro de profesiones</label>

                <div class="variables_cs" style="width: 100%;padding: 20px;margin: 5px;" id="profesionsList">

                </div>

            </div>

            <div class="col_cs ">

                <button id="add_notify" onclick="enviarFormulario()">Agregar notificacion programada</button>

            </div>

        </div>


    </div>


</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>


<script>

    const url = "<?php echo $HOST_EXTERNAL_BACK ?>";
    const back_url  = "<?php echo $back_url?>";
    const BearerToken = "Bearer <?php echo $sessionToken ?>";
    const defaulValues = <?php echo json_encode($defaulValues)?>;
    const edit = "<?php echo $edit ?>"=='1'?true:false;
    const id_notify = "<?php echo $id ?>";

    let countrie = "";
    let week = "";
    let unique = false;
    let selectedProfessions = []

    let title_notify = ''
    let body_notify = ''
    let hour_selected = ''
    let date_notify = ''
    let delay_seconds = ''

    if(edit) {

         countrie = defaulValues.country_id;
         week = defaulValues.dayOfWeek??"";
         unique = defaulValues.unique;
         selectedProfessions = defaulValues.profession_filter

         title_notify = defaulValues.title
         body_notify = defaulValues.description
         hour_selected = defaulValues.hour
         date_notify = defaulValues.date.replaceAll('/','-')
         delay_seconds = defaulValues.delay

    }


    function enviarFormulario(){


        let title_notify  = document.getElementById('title_notify').value;
        let body_notify   = document.getElementById('body_notify').value;
        let hour_selected = document.getElementById('hour_selected').value;
        let date_notify   = document.getElementById('date_notify').value;
        let delay_seconds = document.getElementById('delay_seconds').value;

        console.log("title_notify: ",title_notify)
        console.log("body_notify: ",body_notify)
        console.log("hour_selected: ",hour_selected)
        console.log("date_notify: ",date_notify)
        console.log("delay_seconds: ",delay_seconds)
        console.log("countrie: ",countrie)
        console.log("week: ",week)
        console.log("unique: ",unique)
        console.log("selectedProfessions: ",selectedProfessions)



        var myHeaders = new Headers();
        myHeaders.append("Accept", "application/json");
        myHeaders.append("Content-Type", "application/json");
        myHeaders.append("Authorization", `${BearerToken}`);

        var raw = JSON.stringify({
            "title": title_notify,
            "description": body_notify,
            "profession_filter": selectedProfessions,
            "delay": delay_seconds||0,
            "dayOfWeek": week==""?null:week,
            "unique": unique,
            "hour": hour_selected,
            "country_id": countrie,
            "date": date_notify.replaceAll('-','/')
        });

        var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: raw,
            redirect: 'follow'
        };

        let host = `${url}/createSheduledNotification`

        if (edit){
            host = `${url}/updateSheduledNotification/${id_notify}`
        }

        // console.log(host)


        fetch(host, requestOptions)
            .then(response => response.text())
            .then(result => {

                let success = JSON.parse(result).success
                if(success){
                    Swal.fire(
                        'Guardado',
                        'Operacion exitosa',
                        'success'
                    )
                }else{
                    Swal.fire(
                        'Error',
                        'Operacion exitosa',
                        'error'
                    )
                }
                console.log(back_url)
                location.href = back_url

            })
            .catch(error => console.log('error', error));

    }



    function handleChangeUnique() {
        unique = document.getElementById('unique_select').value == '1' ? true : false
        document.getElementById('unique').classList.toggle('hidden')
        document.getElementById('unique_select_contain').classList.toggle('hidden')
    }

    function handleChangeWeekDay() {
        let val = document.getElementById('week_day_select').value;
        week = val == '' ? null : val
    }

    function handleChangeCountrie() {
        let val = document.getElementById('select_countries').value;
        countrie = val
    }

    function copiarTexto(id) {
        var texto = document.getElementById(id);
        var rango = document.createRange();
        rango.selectNode(texto);
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(rango);
        document.execCommand("copy");
    }

    function expandTextArea(id) {
        const rows = document.getElementById(id).value.split("\n").length;
        document.getElementById(id).rows = rows;
    }




    document.addEventListener('DOMContentLoaded',async ()=>{


        let selected = selectedProfessions
        let profession = await (async () => JSON.parse(await (await fetch(`${url}/professions`)).text()).data)()
        let countries = await (async () => JSON.parse(await (await fetch(`${url}/getCountries`)).text()).data)()

        profession.forEach(profesion => document.getElementById('profesionsList').innerHTML += `<div class="word_copy ${selected.indexOf(profesion._id)>-1?"selected":""}" id="${ profesion._id }" ><p><span > ${profesion.name} </span></p></div>`);
        profession.forEach(profesion => document.getElementById(profesion._id).addEventListener("click", ()=>{
            document.getElementById(profesion._id).classList.toggle('selected')
            selected.indexOf(profesion._id)>-1?selected.splice(selected.indexOf(profesion._id), 1):selected.push(profesion._id)
        }));


        countries.forEach(countrie => {

            document.getElementById('select_countries').innerHTML +=`<option value="${countrie._id}">${countrie.name}</option>`

        })

        document.getElementById('title_notify').value = title_notify
        document.getElementById('body_notify').value = body_notify
        document.getElementById('hour_selected').value = hour_selected
        document.getElementById('date_notify').value = date_notify
        document.getElementById('delay_seconds').value = delay_seconds
        document.getElementById('unique_select').value = unique?"1":"0"
        document.getElementById('select_countries').value = countrie
        document.getElementById('week_day_select').value = week;

        if(unique){
            handleChangeUnique()
        }

    })

</script>


<link rel="stylesheet" href="../../css/All.css">
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

<script>document.getElementsByClassName("content-header")[0].remove();</script>


@endsection
