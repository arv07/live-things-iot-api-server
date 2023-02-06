<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Industria Code</title>
</head>

<body style="display: flex; flex-direction: column; width: 100%; height: auto; justify-content: center; align-items: center; padding-bottom: 20px;">

    <div style="width: 95%; background-color: #012E58; height: 400px; margin-top: 10px; border-radius: 10px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
        <img src="{{ asset('img/slice2.png') }}" alt="description of myimage" style="width: 80px; height: 120px; margin-top: 30px;">
        <p style="margin-top: 20px; color: white; padding: 0 20px 0 20px">Haga click en el siguiente boton para validar su email</p>

        <a href={{url($details['link'])}} style="padding: 10px 30px 10px 30px; background-color: #FFC300; border-radius: 10px; margin-top: 20px;">Validar</a>

        
        @if($details['password'] != null)
        <p style="color: white">Utilice esta contraseña para ingresar después de verificar su email.</p>
        <div style="display: flex; flex-direction: row;">
            <p style="color: white; font-weight: bold">{{$details['password']}}</p>
        </div>
            
        @endif

        <p style="margin-top: 20px; color: white;">También puedes copiar el siguiente enlace</p>
        <p style="margin-top: 10px; color: white; padding: 0 20px 0 20px">{{$details['link']}}</p>

    </div>

</body>

</html>