@extends('layouts.app')

@section('content')
<div class="row header">
  <div class="col-sm-2">IND &nbsp; <i class="fa fa-inr"></i> {{$data['rates']['INR']}}</div>
  <div class="col-sm-2">EUR &nbsp; <i class="fa fa-euro"></i> {{$data['rates']['EUR']}}</div>
  <div class="col-sm-2">USD &nbsp; <i class="fa fa-usd"></i> {{$data['rates']['USD']}}</div>
  <div class="col-sm-2">GBP &nbsp; <i class="fa fa-gbp"></i> {{$data['rates']['GBP']}}</div>
  <div class="col-sm-2">ILS &nbsp; <i class="fa fa-ils"></i> {{$data['rates']['ILS']}}</div>
  <div class="col-sm-2"><select class="base_cur" id="base_cur">
    <option id="" value="INR" disabled >INR</option>
    <option id="" value="USD" disabled>USD</option>
    <option id="" value="EUR" selected="selected" >EUR</option>
    <option id="" value="GBP" disabled >GBP</option>
    <option id="" value="ILS" disabled>ILS</option>
  </select></div>

</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Currency Convertor</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
              
                  <div class="container">
                    <div class="header-value">
                    <h6 id="to-country-value">1</h6>&nbsp;<h6 id="to-country-name">INR</h6>
                   </div>
                     <h3 id="from-country-value">1</h3>&nbsp;<h3 id="from-country-name">EUR</h3>
                    <form>
                      <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                            <input type="text" class="form-control" id="usr" placeholder="<?php echo date('Y/m/d');?>">
                            </div>
                        </div>
                        <div class="col-sm">
                        <div class="form-group">
                          <input type="text" class="form-control" id="to_value" value="1" >
                        </div>
                        </div>
                        <div class="col-sm">
                        <div class="form-group">
                          <select class="form-control to-country" id="to-select">
                              <option id="to" value="INR" selected="selected">INR</option>
                              <option id="to" value="USD">USD</option>
                              <option id="to" value="EUR">EUR</option>
                              <option id="to" value="GBP">GBP</option>
                              <option id="to" value="ILS">ILS</option>
                          </select>
                        </div>
                      </div>      
                      </div>
                      <div class="row">
                        <div class="col-sm">
                          <div class="form-group">   
                          </div>
                        </div>
                        <div class="col-sm">
                        <div class="form-group">
                          <input type="text" class="form-control" id="from_value">
                        </div>
                        </div>
                        <div class="col-sm">
                        <div class="form-group">
                          <select class="form-control from-country" id="from-select">
                              <option id="from" value="INR">INR</option>
                              <option id="from" value="USD">USD</option>
                              <option id="from" value="EUR" selected="selected">EUR</option>
                              <option id="from" value="GBP">GBP</option>
                              <option id="from" value="ILS">ILS</option>
                          </select>
                        </div>
                        </div>
                      </div>
                     </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row history_div">
  <div class="form-group">
      <label><h3>Select date:</h3></label>
      <input type="date" class="form-control history_date" value="<?php echo date('Y-m-d');?>" placeholder="">     
    </div>
</div>
<br>
<div class="chartdiv" id="chartdiv"></div>
@endsection
