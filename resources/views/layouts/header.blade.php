<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="mystyle.css"> --}}
    <link rel="stylesheet" href="http://127.0.0.1:8000/mystyle.css">

    @stack('title')
    <style>
        @media screen and (max-width:520px) {
            #menu {
                font-size: 70px;
            }

            .bar1,
            .bar2,
            .bar3 {
                width: 40px;
                height: 7px;
                margin: 7px 0;

            }

        }




        /* The Modal (background) */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.6);
        }

        /* Modal Content/Box */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 40%;
        }
        .modal-content>p{
            font-size: 18px;
            color: rgb(71, 88, 241)
        }
        /* The Close Button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .loader {
            
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid blue;
  border-bottom: 16px solid blue;
  width: 120px;
  height: 120px;
  animation: spin 2s linear infinite;
  left: 40%;
            top: 40%;
  position: fixed;

}
.loaderbox{
    display:none;
  position: fixed;
            z-index: 1;
            left: 0%;
            top: 0%;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.6);
}
@keyframes spin {
  50% { transform: rotate(50deg); }
  100% { transform: rotate(360deg); }
}
    </style>
</head>

<body>
    <div id="h_container">
        <div id="menu">
            <div class="menu_container" onclick="myFunction(this)" id="iii">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>
            AEMS
        </div>
    </div>
    <div id="mySidenav" class="sidenav">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('user.edit') }}">Update</a>
        @can('role-edit')
            <a href="{{ route('role.show') }}">All Role</a>
            <a href="{{ route('logs') }}">Log </a>
        @endcan
        @can('user-create')
            <a href="{{ route('employee.create') }}">create staff</a>
        @endcan
        @can('user-list')
            <a href="{{ route('employee.index') }}">view staff</a>
        @endcan
        @can('product-list')
            <a href="{{ route('product.index') }}">view product</a>
            <a href="{{ route('products_delete') }}">deleted product</a>

            {{-- <a href="{{route('assign.excel')}}">assign product excel</a> --}}
            <a id="myBtn">assign product excel</a>
        @endcan
        <a href="{{ route('user.product') }}">my product </a>

        {{-- <a href="{{route('logout')}}" onclick="return confirm('are you sure want to logout ?')">Logout</a> --}}
        <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>

    </div>

    {{--  --}}

    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
           
                <div class="close">&times;</div>
                <p>How you want to get the Employee's assigned product details ?</p>
                <a href="{{route('assign.download')}}"><button id="Download">Download</button></a>
                <a href="{{route('assign.excel')}}"><button id="Email">Email</button></a>
            

        </div>

    </div>


    {{--  --}}


    <div class="loaderbox"><div class="loader"></div></div>
    <script src="http://127.0.0.1:8000/jquary.js"></script>

    <script>
        var a = 0;
        // menu script
        function myFunction(x) {
            x.classList.toggle("change");
            if (a == 0) {
                openNav()
                a = 1;
            } else {
                closeNav()
                a = 0;
            }
        }
        // nav script
        function openNav() {
            $("#mySidenav").css("width", "300px");


        }

        function closeNav() {
            $("#mySidenav").css("width", "0px");

        }

        // When the user clicks on the button, open the modal
        $('#myBtn')[0].onclick = function() {
            $("#myModal").css("display", "block");
        }


        // When the user clicks on <span> (x), close the modal
            $('.close')[0].onclick = function() {
            $("#myModal").css("display", "none");
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == $("#myModal")[0]) {
                $("#myModal").css("display", "none");
            }
        }
        
$('#Email')[0].onclick = function() {
            $(".loaderbox").css("display", "block");
}
$('#Download')[0].onclick = function() {
    $(".loaderbox").css("display", "block");

   setTimeout(function () {
    $(".loaderbox").css("display", "none");
   }, 8500);
            
}


    </script>
