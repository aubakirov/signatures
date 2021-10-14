<html>
<head>
    <meta charset="utf-8">

    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th, td {
            padding: 5px;
            text-align: left;
        }
    </style>
</head>
<body>


<div>

    <p>
        Уважаемый, {{$user->name}}!
    </p>

    <p>
        Ваш заказ с номером #{{$signature->id}}
        @if($signature->status == 'denied')
            получил отказ. Причина отказа: {{$signature->description}}
        @else
            одобрен
        @endif
    </p>


</div>

</body>
</html>

