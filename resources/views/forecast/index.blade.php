@extends('layouts.main')

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title') 
    FORECAST MODULE
@endsection 

@section('subtitle')
    LIST OF FORECAST
@endsection

@section('breadcrumbs_1')
    Forecast
@endsection

@section('breadcrumbs_2')
    List
@endsection

@section('button')
    <button class="btn btn-primary mt-2 mt-xl-0" data-bs-toggle="modal" data-bs-target="#modalCreate">UPLOAD FORECAST</button> 
@endsection


@section('main')


<!-- Modal Type-->
<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold badge bg-primary" id="modalCreateLongTitle" style="font-size:16px;">FORECAST MIGRATION</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">  
                    <div class='row'>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="year_forecast">YEAR</label>
                                <input id="year_forecast" class='form-control' type="number" >
                            </div>
                            <div class="form-group">
                                <label for="month_forecast">MONTH</label>
                                <select class="form-control" name="month_forecast" id="month_forecast">
                                    @foreach ( $months as $month)
                                        <option value="{{$month->month_number}}">{{$month->month_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="forecast_upload">UPLOAD FORECAST</label>
                                <input style="padding-top: 11px; padding-left: 20px;" id="forecast_upload" class="form-control" type="file">
                            </div>

                        </div>    
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button onclick="ireneUpload()" class="btn btn-success mt-2 mt-xl-0"style="width:100%;">UPLOAD</button> 
                </div>
            
        </div>
    </div>
</div>
@include('includes.loading')
@endsection

@section('scripts')
<script>
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');   
</script>

<script>
    function ireneUpload(){
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");  
        let upload_file_irene =  $('#forecast_upload')[0].files;
        let year = document.getElementById('year_forecast').value;
        let month = document.getElementById('month_forecast').value; 
        
        // if(!year||!month){
        //     Swal.fire({
        //         position: "CENTER",
        //         icon: "error",
        //         title: "PLEASE COMPLETE THE OTHER FIELDS",
        //         showConfirmButton: false,
        //         timer: 1500
        //     });
        // }else{
            var fd = new FormData();
            fd.append('file',upload_file_irene[0]);
            fd.append('_token',CSRF_TOKEN);
            fd.append('month',month);
            fd.append('year',year);
            $.ajax({
                type:'POST',
                url:"{{ route('forecast.store') }}",
                contentType: false,
                processData: false,
                data: fd,
                success:function(data){
                    console.log(data);
                    $.ajax({
                        type:'post',
                        headers: {  'Access-Control-Allow-Origin': '*' },
                        url:'http://192.168.0.183:81/api/Forecast/UploadForecast',
                        data: JSON.stringify(data),
                        crossDomain: true,
                        dataType: 'json',
                        contentType: "application/json; charset=utf-8",
                        success:function(data){
                            console.log(data);
                        }
                    });
                }
            });
        // }        
    }
</script>
@endsection