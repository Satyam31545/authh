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
    #menu{
      font-size: 70px;
       }
       .bar1, .bar2, .bar3 {
  width: 40px;
  height: 7px;
  margin: 7px 0;

}
       
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
        <a href="http://127.0.0.1:8000/home">Home</a>
        <a href="http://127.0.0.1:8000/update">Update</a>
        @can('role-edit')
           <a href="http://127.0.0.1:8000/Role_update"> Role Update</a>
        @endcan 
        @can('user-create')
           <a href="http://127.0.0.1:8000/employee/create">create staff</a>
        @endcan 
        @can('user-list')
          <a href="http://127.0.0.1:8000/employee">view staff</a>
        @endcan 
        @can('product-list')
        <a href="http://127.0.0.1:8000/product">view product</a>
      @endcan 
      <a href="http://127.0.0.1:8000/myproduct">my product </a>

        <a href="/logout" onclick="return confirm('are you sure want to logout ?')">Logout</a>

    </div>
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
            document.getElementById("mySidenav").style.width = "300px";
           

        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
           
        }

    </script>
