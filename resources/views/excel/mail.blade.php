<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            background-color: #e2e8f5;

        }

        #header {
            background-color: rgb(255, 255, 255);
            font-size: 45px;
            padding: 10px;
            margin: 10px;
        }

        #body {
            padding: 20px;
            margin: 10px;
            background-color: rgb(255, 255, 255);

        }

        #footer {
            font-size: 20px;
            background-color: rgb(255, 255, 255);
            text-align: center;
            padding-top: 20px;
            padding-bottom: 10px;
            margin: 10px;
        }

        img {
            width: 100px;
            float: left;
            padding-left: 15px;
            padding-right: 15px;
        }

        a {
            text-decoration: none;
        }

        p {
            font-size: 20px;
            padding-left: 50px;
        }

        #end {
            text-align: center;
            margin-top: 20px;
            font-size: 20px;
        }

        #greate {
            padding-left: 15px;
            font-size: 35px;
        }

        #card {
            background-color: #ececf0;
            border-left: 8px solid #F7991C;
            padding: 15px;
            margin-top: 10px;
        }

        #card>hr {
            background-color: #F7991C;
            height: 2px;
            border: 0px solid #F7991C;
            width: 80%;

        }

        #card>p>a {
            font-size: 26px;

        }

        #card>p {
            font-size: 28px;
        }
    </style>
</head>

<body>
    <div id="header">
        <img src="{{ $message->embed(public_path('logo.png')) }}" alt="">
        Three38inc
    </div>
    <div id="body">
        <p id="greate"> Dear User, </p>

        <p> We are sending you "employee's assigned product" details as till {{ $time }} in the form of excel
            file
            attached to this email.</p>

        <p> for further details visit to our site.</p>
        <div id="card" style="border-left: 8px solid #B2B9CB">
            
              <p>  total employees: {{$employee}} </p>
               <p> total products: {{$product}}</p>
               <p> total quantity of products: {{$quantity}}</p>
            
            


        </div>

        <div id="card">
            <p>
                To see your product click on the below link.
            </p>
            <hr>

            <p>
                <a href="http://127.0.0.1:8000/employee_product_export">click</a>
            </p>
        </div>



    </div>
    <div id="footer">

        <p><a href="www.three38inc.com">www.three38inc.com</a></p>
        <p><a href="satyamssingh9455@gmail.com">satyamssingh9455@gmail.com</a></p>
    </div>
    <div id="end">
        this is a test mail
    </div>
</body>

</html>
