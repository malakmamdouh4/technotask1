<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->


    <!-- CDN Bootstrap   -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">


    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>


    <!-- CDN font-awesome  -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        
    
    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->

    <!-- Custom fonts for this template-->
  <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/css/sb-admin.css" rel="stylesheet">

    <!--CKEditor Plugin-->
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>

    <style>
       
        body
        {
            margin:0px;
            padding:0px;
            background-color:#EAF2FF;
        }

        /* start login form */ 
        .login , .register
        {
            width:65%;
            margin:50px auto;
            padding:30px
        }
        .register 
        {
            margin:10px auto;
        }
        .login input[type=text] , .register input[type=text]
        {
            width:100%;
            margin-left:0px
        }
        /* end login form */ 

        /* start profile */
        .profile
        {
            padding:30px
        }
        /* end profile */
        
        .sidebar , .home , .settings , .login , .register
        {
            background-color:white;
            border-radius:20px
        }

        /* start sidebar */
        .sidebar
        {
            height: 80vh;
        }
        .sidebar h4 
        {
           padding-top :10px;
        }
        .sidebar img
        {
            width:50px;
            height:50px;
            margin-right:10px;
            margin-left:30px;
            border-radius:15px
        }
        .sidebar ul  
        {
              list-style : none  ;
        }
        .sidebar ul li 
        {
            padding-top:10px ;
        }
        .sidebar ul li a
        {
            font-size : 20px ;
            text-decoration :none ;
        }
        .sidebar i
        {
            color:gray ;
            font-size:18px;
            padding-right:10px
        }
        /* end sidebar */


        /* start home */
        .home , .settings
        {
            margin-left:30px;
        }
        .home h4 , .settings h4
        {
            padding-top : 10px;
            text-align : center
        }
        .home p
        {
            text-align: center;
            font-size : 40px ;
            font-weight: bold ;
            color:gray ;
        }
        .home a 
        {
            text-decoration : none ;
        }
        /* end home */

        /* start settings */
        .settings p
        {
            font-size : 20px ;
            margin-left:30px ;
        }
        .settings span 
        {
            color:gray
        }
        .settings img
        {
            width:95%;
            height:250px;
            display: block;
            margin-left: 0px auto;
            margin-right: auto;
        }
        .settings .edit
        {
            float: right;
            margin-right:10px;
        }
        .settings .edit a
        {
            text-decoration :none ;
            color:black
        }
        .settings .edit i
        {
            color:green
        }
        .uimage
        {
            position: relative;
        }
        .bottom-right
        {
            position: absolute;
            bottom: 210px;
            right: 60px;
        }
        /* end settings */
        

        /* start edit form  */
        .modal 
        {
        display: none; 
        position: fixed; 
        z-index: 1; 
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%; 
        overflow: auto; 
        background-color: rgb(0,0,0); 
        background-color: rgba(0,0,0,0.4); 
        padding-top: 60px;
        }
        .modal-content {
        background-color: #fefefe;
        margin: 5% auto 15% auto; 
        border: 1px solid #888;
        width: 80%; 
        }
        .img-container {
        text-align: center;
        margin-top: 25px;
        position: relative;
        }
        input[type=text]
        {
        width: 70%;
        padding: 12px 20px;
        margin: 8px 10px;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-sizing: border-box;
        }
         .btn-form
        {
        background-color: #3FBFC0;
        color: #fff  ;
        padding: 7px 20px;
        border: none;
        cursor: pointer;
        border-radius: 50px;
        width: 100px;
        transition: 0.3s;
        margin-left: 42% !important;
        margin-top: 20px;
        margin-bottom: 20px;
        }
        .settings button
        {
            cursor: pointer;
            border:none ;
            background:none
        }
        .settings button:hover, button:focus 
        {
            outline: none;
        }
        .btn-form:hover
        {
        background-color: #37b1b1;
        }
        .close {
        position: absolute;
        right: 25px;
        top: 0;
        color: #000;
        font-size: 35px;
        font-weight: bold;
        }
        .close:hover,
        .close:focus {
        color: red !important;
        cursor: pointer;
        }

        /* Add Zoom Animation */
        .animate {
        -webkit-animation: animatezoom 0.6s;
        animation: animatezoom 0.6s
        }

        @-webkit-keyframes animatezoom {
        from {-webkit-transform: scale(0)} 
        to {-webkit-transform: scale(1)}
        }
        
        @keyframes animatezoom {
        from {transform: scale(0)} 
        to {transform: scale(1)}
        }
        /* end edit form */ 




        @media screen and (max-width: 599px )  
        {
            .login , .register
            {
                width:80%
            }
            .home , .settings
           {
             margin-top:20px ;
             margin-left:0px
           }
           .home .name 
           {
             display:none ;
           }
           .sidebar h4 
            {
                text-align : center
            }
           
        }


        @media screen and (min-width: 600px )  and ( max-width: 767px )
        {
            .login , .register
            {
                width:60%
            }
            .sidebar
            {
                width:100%
            }
           .home , .settings
           {
             margin-left:0px ;
             margin-top:20px ;
           }
           .sidebar h4 
            {
                text-align : center
            }
        }

        
        @media screen and (min-width: 768px )  and ( max-width: 991px )
        {
            .sidebar i
            {
                display:none;
            }
        }

        
    </style>

    @yield('css_role_page')
</head>
<body>
    <div id="app">

        <main class="py-4">
            @yield('content')
        </main>
    </div>


     <!-- Bootstrap core JavaScript-->
  <script src="/vendor/jquery/jquery.min.js"></script>
  <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  
  <script src="/vendor/datatables/jquery.dataTables.js"></script>
  <script src="/vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="/js/sb-admin.js"></script>

  <!-- Demo scripts for this page-->
  <script src="/js/demo/datatables-demo.js"></script> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    
    
    @yield('js_user_page')

    @yield('js_role_page')

</body>
</html>
