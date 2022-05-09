
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>El Corral - CodeSoft</title>

    <!-- Favicon -->
    <?php $admin_favicon = Voyager::setting('admin.icon_image', ''); ?>

        <link rel="shortcut icon" href="{{ asset('images/icon.png') }}" type="image/png">

        <link rel="shortcut icon" href="{{ Voyager::image($admin_favicon) }}" type="image/png">


    <link href="https://fonts.googleapis.com/css?family=Noto+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <style>
        body {
            font-family: 'Noto Sans', sans-serif;
            background: url("{{ url('storage/'.setting('auxiliares.fondo_tickets')) }}") no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            overflow-y:hidden
            /* margin: 0;
            padding: 0; */
        }
        .title{
            font-size: 50px;
            color: white;
            margin-top: 20px
        }
        .dark-mask{
            position: absolute;
            top:0px;
            bottom: 0px;
            left:0px;
            background-color:rgba(251, 0, 0, 0.5);
            width: 100%;
            height: 100 hv;
            z-index: 1;
        }
        .footer{
            position:fixed;
            bottom:0px;
            left:0px;
            width: 100%;
            background-color:rgba(0, 0, 0, 0.7);
            z-index: 10000;
        }
        .footer-content{
            margin: 10px 20px;
            color: white;
            font-size: 20px;
        }
        iframe{
            background-color: rgb(249, 249, 249)
        }
    </style>
</head>
<body>
    <div class="container-fluid">  
        <div class="row multimedia">
            <div class="col-5">
                <img src="{{ asset('images/icon.png') }}" alt="GADBENI" class="img-fluid center" width="850px">  
            </div>
            <div class="col-7">
                <br><br>
                <div class="row" style="text-center">
                    <div class="col-1">                                     
                    </div>
                    <div class="col-8 padre" id="categoria">
                        
                    </div>
                    <div class="col-3">                                     
                    </div>
                </div> 
               
                <br><br>               
                <div class="row  padre">
                    <div class="col-6 lote" id="lote">                
                                                           
                    </div>
                    <div class="col-6 padre" id=cantidad>
                        
                    </div>
                </div> 
                <br><br>
                <br><br>
                <div class="row">
                    <div class="col-6" id="precio">
                                           
                    </div>
                </div> 
            </div>
        </div> 
        <div class="footer">
            <div class="footer-content">
                El Corral - <span style="color: {{ env('APP_COLOR') }}">Trinidad-Beni-Bolivia</span>
            </div>
        </div>
    </div>
    

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <style>
        .card{
            background-color:rgba(186, 175, 175, 0.7);
            color:white;
            border: 10px solid rgba(0, 0, 0, 0.7);
        }
        .ticket-active{
            animation: colorchange 3s infinite; /* animation-name followed by duration in seconds*/
             /* you could also use milliseconds (ms) or something like 2.5s */
            -webkit-animation: colorchange 3s infinite; /* Chrome and Safari */
        }
        .multimedia{
            position: fixed;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100vh;
            z-index: 10000;
            background-color: rgb(225, 225, 225)
        }
        .texto{
            text-align: center;
            border-radius: 10px 10px 10px 10px;
            color: #000000;
            border-color: rgb(63, 63, 63);
            background-color: rgb(225, 225, 225)
        }

        .padre {
            /* IMPORTANTE */
            text-align: center;
        }
        .lote {
            /* IMPORTANTE */
            text-align: center;
        }

        @keyframes colorchange
        {
            0%  {border: 10px solid rgba(0, 0, 0, 0.7);}
            20%   {border: 10px solid {{ env('APP_COLOR') }};}
            80%  {border: 10px solid rgba(0, 0, 0, 0.7);}
        }
        @-webkit-keyframes colorchange /* Safari and Chrome - necessary duplicate */
        {
            0%  {border: 10px solid rgba(0, 0, 0, 0.7);}
            25%   {border: 10px solid {{ env('APP_COLOR') }};}
            75%  {border: 10px solid rgba(0, 0, 0, 0.7);}
        }


        /* Slider */
        @keyframes slide {
            0% { transform: translateX(0); }
            50% { transform: translateX(0); }

            51% { transform: translateX(-100%); }
            100% { transform: translateX(-100%); }

            /* 35% { transform: translateX(-200%); }
            50% { transform: translateX(-200%); }

            55% { transform: translateX(-300%); }
            70% { transform: translateX(-300%); }

            75% { transform: translateX(-400%); }
            90% { transform: translateX(-400%); }

            95% { transform: translateX(-500%); }
            100% { transform: translateX(-500%); } */
        }

        .wrapper {
            width: 100%;
            position: relative;
            z-index: 10;
        }

        .slider {
            width: 100%;
            position: relative;
        }

        .slides {
            width: 100%;
            position: relative;
            display: flex;
            overflow: hidden;
            padding: 0px
        }

        .slide {
            width: 100%;
            flex-shrink: 0;
            animation-name: slide;
            animation-duration: 60s;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
            list-style: none
        }

        .slides:hover .slide {
            animation-play-state: paused;
        }

        .slide img {
            width: 100%;
            vertical-align: top;
        }

        .slide a {
            width: 100%;
            display: inline-block;
            position: relative;
        }

        .slide:target {
            animation-name: none;
            position: absolute;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            z-index: 50;
        }

        .slider-controler {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            text-align: center;
            /* padding: 5px; */
            background-color: rgba(0,0,0,0.5);
            z-index: 100;
        }

        .slider-controler li {
            margin: 0 0.5rem;
            display: inline-block;
            vertical-align: top;
        }

        .slider-controler a {
            display: inline-block;
            vertical-align: top;
            text-decoration: none;
            color: white;
            font-size: 1.5rem;
        }
    </style>

    <script>
        
        setInterval(     
                   
                   function () 
                   {       
                        $.get('{{route('board.board')}}', function(data){
                            // alert(data[0].lote)
                            var categoria ='<span class="texto" style="font-size:350%" id="cant"><b>'+data[0].category+'</b></span>'
                            var cantidad = '<span class="input-group-text texto" style="font-size:350%"><b>CANTIDAD: <br>'+data[0].quantity+'</b></span>'
                            var lote = '<span class="input-group-text texto" style="font-size:350%"><b>LOTE:<br>'+data[0].lote+'</b></span>'
                            var precio ='<span class="input-group-text texto" style="font-size:350%"><b>PRECIO: <br>'+data[0].price+'</b></span>'

                            $('#categoria').html(categoria);
                            $('#precio').html(precio);
                            $('#lote').html(lote);
                            $('#cantidad').html(cantidad);        
                        });
                   }, 300 //en medio minuto se recargará solo la campana de notificación..
               );
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.4.0/socket.io.js" integrity="sha512-nYuHvSAhY5lFZ4ixSViOwsEKFvlxHMU2NHts1ILuJgOS6ptUmAGt/0i5czIgMOahKZ6JN84YFDA+mCdky7dD8A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
       
    </script>

</body>
</html>

{{--  --}}