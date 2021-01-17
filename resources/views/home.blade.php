<!DOCTYPE html>
<html>
<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Eraldo - ES Tech Test</title>
		<meta name="description" content="Take a look at this test.">
		
		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

		<!-- Bootstrap CSS and JS-->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

		<!-- CSS -->
        <style type="text/css">
            .span-title{
                margin-bottom: 15px;
                display: block;
                font-weight: bold;
            }
            .success-alert-csv{
                margin-top: 10px;
                margin-bottom: 0;
            }
            .card-tabble-body{
                overflow: auto;
                height: 259px;
                padding-bottom:20px;
            }
        </style>

	</head>
<body>
   
<div class="container">
    <div class="card bg-light mt-3">
        <div class="card-body">
        <span class="span-title">1. CSV Upload to database (CSV -> Table: prices)</span>
            <form action="{{ url('/importFunc') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control" required>
                <br>
                <button class="btn btn-success">Import CSV file</button>
                <!-- <a class="btn btn-warning" href="{{ url('/export') }}">Export User Data</a> -->
            </form>
            
            @if(session('success'))
            <div class="alert alert-success success-alert-csv" role="alert">
                File imported successfully
            </div>
            @endif
        </div>
    </div>
</div>
<div class="container">
    <div class="card bg-light mt-3">
        <div class="card-body card-tabble-body">
        <span class="span-title">2. Real-time read JSON (import_archives/live_prices.json)</span>
            <table class="table table-hover">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Sku</th>
                    <th scope="col">Account</th>
                    <th scope="col">Price</th>
                    </tr>
                </thead>
                <tbody class='jsonReturn'>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>

<script type="text/javascript">

    const formatter = new Intl.NumberFormat('it-IT', {
        style: 'currency',
        currency: 'EUR',
        minimumFractionDigits: 2
    })

    $( document ).ready(function() {
        $.ajax({
				method: "POST",
				url: "/loadJson",
				data: { "_token": "{{ csrf_token() }}"}
        }).done(function( resultReturn ) {
            var html = '';
            $( resultReturn ).each(function( index, element ) {
                html += '<tr>';
                html += '<th scope="row">'+index+'</th>';
                html += '<td>'+element.sku+'</td>';
                if (typeof element.account !== 'undefined'){
                    html += '<td>'+element.account+'</td>';
                }else{
                    html += '<td>N/A</td>';
                }
                html += '<td>'+formatter.format(element.price)+'</td>';
                html += '</tr>';
            });
            $('.jsonReturn').append(html);
        });
    });

</script>
</html> 