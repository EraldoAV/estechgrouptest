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
            .hidden{
                display: none;
            }
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
            .search-buttom{
                margin-top:20px;
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
<div class="container">
    <div class="card bg-light mt-3">
        <div class="card-body card-tabble-body" style="height: auto;">
            <span class="span-title">3. Develop an output - get a product price</span>
            <form id="search">
                @csrf
                <div class="row g-2">
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="product-code" class="form-control" id="product-code" placeholder="Product Code" required>
                            <label for="floatingInput">Product Code</label>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="account-id" class="form-control" id="account-id" placeholder="Account ID">
                            <label for="floatingInput">Account ID</label>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success search-buttom" type="submit">Search</button>
            </form>
            <div class='searchTable hidden'>
            <table class="table table-hover">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Sku</th>
                    <th scope="col">Account</th>
                    <th scope="col">Price</th>
                    <th scope="col">Origin</th>
                    </tr>
                </thead>
                <tbody class='searchTableJson'>
                    
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
</body>

<script type="text/javascript">

    //global vars
    var globaljsonLiveGlobal;
    var globallooping1;
    var globallooping2;

    /*
        Euro currency formatter.
    */
    const formatter = new Intl.NumberFormat('it-IT', {
        style: 'currency',
        currency: 'EUR',
        minimumFractionDigits: 2
    })
    /*
        Ajax to read JSON file and bring the data.
    */
    $( document ).ready(function() {
        var arrPop = [];
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
                    arrPop[index] = {'sku' : element.sku, 'account' : element.account, 'price' : element.price };
                    html += '<td>'+element.account+'</td>';
                }else{
                    arrPop[index] = {'sku' : element.sku, 'account' : 0, 'price' : element.price };
                    html += '<td>'+null+'</td>';
                }
                html += '<td>'+formatter.format(element.price)+'</td>';
                html += '</tr>';
            });

            //saving in global var to use the data in exercise 3
            globaljsonLiveGlobal = JSON.stringify(arrPop);
            
            $('.jsonReturn').append(html);
        });
    });
    /*
        DB search

    */
    $("#search").submit(function(e){

        $('.searchTableJson').find('tr').remove();
        var pdc_code = $('#product-code').val();
        var acc_id = $('#account-id').val();
        var jsonLiveData = JSON.parse(globaljsonLiveGlobal);
        globallooping1 = "";
        globallooping2 = "";
        
        var cont = 0;
        
        //searcher function to multiple SVU
        function searcherJson(value,value2,aim) {
            var noSpaces = value.replace(' ','');
            var splited = noSpaces.split(',');
            var arr = [];
            
            for(x = 0; x < splited.length; x++){
                arr.push(aim.filter(obj => obj.sku === splited[x] && obj.account == value2));
            }
            return arr;
        }
                
        /* 
            first, search in the json live file 
        */
        
        if ($('#account-id').val() !== ''){
            var searchJsonLiveData = jsonLiveData.filter(x => x.sku === $('#product-code').val() && x.account === $('#account-id').val());
        }else{
            var searchJsonLiveData = searcherJson($('#product-code').val(),0,jsonLiveData);
        }
        
        globallooping1 = searchJsonLiveData;

        /*
            second, search in DB
        */
        ;

        $.ajax({
            method: "POST",
            url: "/searchDB",
            data: { "sku": $('#product-code').val(), "account": $('#account-id').val(), "_token": "{{ csrf_token() }}"}
        }).done(function( resultReturn ) {
            //populating the json live array data with DB data
            if(resultReturn != 0){
                globallooping2 = resultReturn;
            }else{
                globallooping2 = 0;
            }
        
            var looping1 = globallooping1;
            var looping2 = JSON.parse(globallooping2);
            var html = '';

            //building the frond-end table -> json file
            $.each(looping1, function( index, element ) {
                html += '<tr>';
                html += '<th scope="row">'+index+'</th>';
                html += '<td>'+element[index].sku+'</td>';
                if (element[index].account !== 0){
                    html += '<td>'+element[index].account+'</td>';
                }else{
                    html += '<td>'+null+'</td>';
                }
                html += '<td>'+formatter.format(element[index].price)+'</td>';
                html += '<td>live_prices.json</td>';
                html += '</tr>'; 
                cont++; 
            });

            //building the frond-end table -> DB
            $.each(looping2, function( index, element) { 
                html += '<tr>';
                html += '<th scope="row">'+cont+'</th>';
                html += '<td>'+element.sku+'</td>';
                if (element.account !== 0){
                    html += '<td>'+element.account+'</td>';
                }else{
                    html += '<td>'+null+'</td>';
                }
                html += '<td>'+formatter.format(element.price)+'</td>';
                html += '<td>Table DB</td>';
                html += '</tr>';
                cont++;
            });

            $('.searchTableJson').append(html);
            $('.searchTable').removeClass('hidden');
            
        });
        //prevent submit
        e.preventDefault();
    });

</script>
</html> 