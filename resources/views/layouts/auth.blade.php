<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <style>
        html, body {
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Roboto, Arial, sans-serif;
            font-size: 15px;
            height: 100%;
        }
        form {
            /*border: 5px solid #f1f1f1;*/
        }
        .auth__label{
            display: block;
            margin-bottom: 4px;
            margin-top: 25px;
        }
        .auth__label-first{
            display: block;
            margin-bottom: 4px;
            margin-top: 0px;
        }
        input[type=text], input[type=password] {
            width: 100%;
            padding: 16px 24px;
            margin: 8px 0;
            display: inline-block;
            border: none;
            box-sizing: border-box;
            box-shadow: 8px -10px 23px #F1F1F1, -8px 10px 23px #F1F1F1;
            border-radius: 35px;
        }

        input:focus-visible{
            outline: none;
        }

        button {
            background: #883CDA;
            border-radius: 35px;
            color: white;
            padding: 14px 0;
            margin: 10px 0;
            border: none;
            cursor: grabbing;
            width: 100%;
            transition: all 0.3s;
        }
        h1 {
            text-align:center;
            fone-size:18;
        }
        button:hover {
            box-shadow: 0px 1px 18px #9F8FB0;
        }
        .auth__formcontainer {
            text-align: left;
            margin: 24px 50px 12px;
        }
        .auth__fieldsbox {
            padding: 16px 0;
            text-align:left;
        }
        .auth__footer{
            display: flex;
            justify-content: space-around;
            align-items: center;
            min-height: 35px;
            min-width: 300px;
        }
        .auth__footer a{
            font-style: normal;
            font-weight: 700;
            font-size: 16px;
            line-height: 19px;
            color: #883CDA;
            text-decoration: none;
        }
        .auth__footer a:hover{
            text-decoration: underline;
        }
        .auth__error-message{
            color: red;
            font-size: 15px;
            margin-top: -5px;
        }
        /* Change styles for span on extra small screens */
        @media screen and (max-width: 460px) {
            html, body {
                width: 100%;
                min-width: 430px;
            }
        }
    </style>
</head>
<body>
<form action="@yield('action')" method="@yield('method')">
    @csrf
    <h1>@yield('form_title')</h1>
    <div class="auth__formcontainer">
        <div class="auth__fieldsbox">
            @yield('form_body')

        </div>
        <button type="submit">@yield('button_text')</button>
        <div class="auth__footer">
            @yield('form_footer')
        </div>
    </div>
</form>


</body>
</html>
