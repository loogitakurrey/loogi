<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Curreny Convertor') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <style>
    #chartdiv {
      width: 60%;
      height: 500px;
      margin:0px 250px 60px;
    }
    </style>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light  shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Currency Convertor
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>

am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv", am4charts.XYChart);
chart.scrollbarX = new am4core.Scrollbar();


$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
    });
var date = $('.history_date').val();
//var date = '2019-07-09';
        $.ajax({
        type:'POST',
        url:'{!! url('history') !!}',
        data:{date:date},
        dataType: "json",
        //dataType:'application/json',
        success:function(data){
            var data = JSON.stringify(data);
            var data = JSON.parse(data);
            //alert(data);
            //console.log(data.INR);
            chart.data = [{
              "country": "INR",
              "visits": data.INR
            }, {
              "country": "USD",
              "visits": data.USD
            }, {
              "country": "EUR",
              "visits": data.EUR
            }, {
              "country": "GBP",
              "visits": data.GBP
            }, {
              "country": "ILS",
              "visits": data.ILS
            }];
        }
        });


$('.history_date').change(function(){
    var date = $(this).val();
    //alert(date);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
    });
        $.ajax({
        type:'POST',
        url:'{!! url('history') !!}',
        data:{date:date},
        dataType: "json",
        //dataType:'application/json',
        success:function(data){
            var data = JSON.stringify(data);
            var data = JSON.parse(data);
            //alert(data);
            //console.log(data.INR);
            chart.data = [{
              "country": "INR",
              "visits": data.INR
            }, {
              "country": "USD",
              "visits": data.USD
            }, {
              "country": "EUR",
              "visits": data.EUR
            }, {
              "country": "GBP",
              "visits": data.GBP
            }, {
              "country": "ILS",
              "visits": data.ILS
            }];
        }
        });

});
// Add data

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "country";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;
categoryAxis.renderer.labels.template.horizontalCenter = "right";
categoryAxis.renderer.labels.template.verticalCenter = "middle";
categoryAxis.renderer.labels.template.rotation = 270;
categoryAxis.tooltip.disabled = true;
categoryAxis.renderer.minHeight = 110;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.renderer.minWidth = 50;

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.sequencedInterpolation = true;
series.dataFields.valueY = "visits";
series.dataFields.categoryX = "country";
series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
series.columns.template.strokeWidth = 0;

series.tooltip.pointerOrientation = "vertical";

series.columns.template.column.cornerRadiusTopLeft = 10;
series.columns.template.column.cornerRadiusTopRight = 10;
series.columns.template.column.fillOpacity = 0.8;

// on hover, make corner radiuses bigger
var hoverState = series.columns.template.column.states.create("hover");
hoverState.properties.cornerRadiusTopLeft = 0;
hoverState.properties.cornerRadiusTopRight = 0;
hoverState.properties.fillOpacity = 1;

series.columns.template.adapter.add("fill", function(fill, target) {
  return chart.colors.getIndex(target.dataItem.index);
});

// Cursor
chart.cursor = new am4charts.XYCursor();

}); // end am4core.ready()


</script>



<script type="text/javascript">
    $(document).ready(function(){
    var to_value = $('#to_value').val();
    var to_country = $('select.to-country').find('option[selected]').val();
    var from_country = $('select.from-country').find('option[selected]').val();
     //alert(to_country);
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
       });
            $.ajax({
            type:'POST',
            url:'{!! url('base') !!}',
            data:{to_value:to_value,to_country:to_country,from_country:from_country},
            success:function(data){
                var final = data*to_value;
                $('#from-country-value').html(final);
                $('#from_value').val(final);
            }
            });




});
</script>
<script type="text/javascript">
    $(document).ready(function(){
    $("#to_value").change(function(){
        var to_value= $('#to_value').val();
        $('#to-country-value').html(to_value);
        var to_value = $('#to_value').val();
        var to_country = $('select.to-country').children("option:selected").val();
        var from_country = $('select.from-country').children("option:selected").val();
         //alert(to_country);
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
           });
            $.ajax({
            type:'POST',
             url:'{!! url('base') !!}',
            data:{to_value:to_value,to_country:to_country,from_country:from_country},
            success:function(data){
                var final = data*to_value;
                $('#from-country-value').html(final);
                $('#from_value').val(final);
            }
            });
    });
});
</script>





<script type="text/javascript">
    $(document).ready(function(){
    $("select.from-country").change(function(){
        var selectedCountry = $(this).children("option:selected").val();
        $('#from-country-name').html(selectedCountry);

        var to_value2 = $('#to_value').val();
        var to_country2 = $('select.to-country').children("option:selected").val();
        //var from_country2 = $('select.from-country').find('option[selected]').val();
        //alert(from_country);
       $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
       });
            $.ajax({
            type:'POST',
             url:'{!! url('base') !!}',
            data:{to_value:to_value2,to_country:to_country2,from_country:selectedCountry},
            success:function(data){
                //alert(data);
                var final = data*to_value2;
                $('#from-country-value').html(final);
                $('#from_value').val(final);
            }
            });
        //alert("You have selected the country - " + selectedCountry);
       
        
    });
});
</script>
<script type="text/javascript">
    $(document).ready(function(){
    $("select.to-country").change(function(){
        var selectedCountry = $(this).children("option:selected").val();
        var to_value= $('#to_value').val();
        $('#to-country-name').html(selectedCountry);
        $('#to-country-value').html(to_value);
        var to_value1 = $('#to_value').val();
        var to_country1 = $('select.to-country').children("option:selected").val();
        var from_country1 = $('select.from-country').children("option:selected").val();
        //alert(from_country);
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
       });
            $.ajax({
            type:'POST',
             url:'{!! url('base') !!}',
            data:{to_value:to_value1,to_country:selectedCountry,from_country:from_country1},
            success:function(data){
                //alert(data);
                var final = data*to_value1;
                $('#from-country-value').html(final);
                $('#from_value').val(final);
            }
            });

    });
});
</script>
<script type="text/javascript">
    $(document).ready(function(){
    $("select.base_cur").change(function(){
        var base_cur = $(this).children("option:selected").val();

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
       });
            $.ajax({
            type:'POST',
            url:'{!! url('base') !!}',
            data:{base_cur:base_cur},
            success:function(data){
                alert(data);
                
            }
            });
        //alert("You have selected the country - " + selectedCountry);
       
        
    });
});
</script><script type="text/javascript">
    $(document).ready(function(){
    $("#from_value").change(function(){
        var from_value= $('#from_value').val();
        $('#to-country-value').html(to_value);
        var to_value = $('#to_value').val();
        var to_country = $('select.to-country').children("option:selected").val();
        var from_country = $('select.from-country').children("option:selected").val();
         //alert(to_country);
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
           });
            $.ajax({
            type:'POST',
            url:'{!! url('base') !!}',
            data:{to_value:from_value,to_country:from_country,from_country:to_country},
            success:function(data){
                var final = data*from_value;
                $('#to-country-value').html(final);
                $('#to_value').val(final);
                $('#from-country-value').html(from_value);
            }
            });
    });
});
</script>
<script>

</script>
</html>
 