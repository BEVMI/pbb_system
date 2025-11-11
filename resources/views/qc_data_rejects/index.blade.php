<?php 
$layout = session('pms_pbb_design');
if($layout == 1):
    $layout_post = 'main';
else:
    $layout_post = 'main1';
endif;
$user_auth = Auth::user();
?>

@extends('layouts.'.$layout_post)

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{asset('css/select2.min.css')}}" type="text/css">
<style>
    .irene_thead {
        font-weight: bold;
        background-color: #5e72e4;
        color: white;
        vertical-align: middle;
    }
    td{
        vertical-align: middle;
    }
    .tooltip {
        z-index: 100000000; 
    }
    span.select2.select2-container.select2-container--default.select2-container--below.select2-container--open{
        font-size:12px !important;
        font-weight: bold;
    }

    span.select2.select2-container.select2-container--default.select2-container--below,span.select2.select2-container.select2-container--default {
        font-size:12px !important;
        font-weight: bold;
    }

    span.select2.select2-container.select2-container--default.select2-container--focus {
        font-size:12px !important;
        font-weight: bold;
    }

    span.select2-selection.select2-selection--single {
      height:35px !important;
      font-size:12px !important;
      font-weight: bold;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 35px;
      position: absolute;
      top: 1px;
      right: 1px;
      width: 20px;
    }
    .select2-container--default .select2-selection--single{
        border:1px solid #dee2e6 !important;
        font-size:12px !important;
        font-weight: bold;
    }

    .select2-container .select2-selection--single .select2-selection__rendered{
        margin-top:3px !important;
        font-size:12px !important;
        font-weight: bold;
        height: 50px;
		overflow-y: auto !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        display: block !important;
    }
    iframe{
        margin: 0px !important;
        padding: 0px !important;
        border:none;
    }
</style>

@endsection

@section('title') 
    QC REJECTS MODULE
@endsection 

@section('subtitle')
    LIST OF QC REJECTS MODULE

@endsection

@section('breadcrumbs_1')
    QC REJECTS MODULE
@endsection

@section('breadcrumbs_2')
    LIST
@endsection

@section('button')
@endsection

@section('main')
<script>
    let irene =[];
    let ireneUpdate =[];
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2">
            <label for="rejectName">MONTH</label>
            <select onchange="searchRejects(1)" class="form-control" name="month_select" id="month_select">
                @for($m=1; $m<=12; ++$m)
                    <?php 
                        $month = str_pad($m, 2, '0', STR_PAD_LEFT);
                        $monthName = date('F', mktime(0, 0, 0, $m, 10));
                    ?>
                    <option value="{{ $month }}" {{ $month == date('m') ? 'selected' : '' }}>{{ $monthName }}</option>
                @endfor
            </select>
        </div>
        <div class="col-lg-2">
            <label for="YEAR">YEAR</label>
            <select onchange="searchRejects(1)" name="year_select" id="year_select" class="form-control">
                @for($y=2024; $y<=2050; $y++)
                    <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <div class="col-lg-2">
            <label for="rejectCode">Page:</label>
             <select onchange="searchRejects(0)" class="form-control" name="page" id="pages">
                @for($i=1; $i<=$reject_datas->pages; $i++)
                    <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
        </div>
        <div class="col-lg-4">
         
        </div>
        <div class="col-lg-2">
            <br>
            <button class="btn btn-primary" style="width:100% ;" data-bs-toggle="modal" data-bs-target="#modalAdd">ADD REJECT</button>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-12">
            <table class="table table-bordered table-hover table-responsive-lg">
                <thead class="irene_thead">
                    <tr class="text-center">
                        <th>JOB ID</th>
                        <th>QTY</th>
                        <th>BATCH</th>
                        <th>MFG.DATE</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <?php $irene = ''; ?>
                <tbody id="qc_rejects_table_body">
                    @foreach($reject_datas->qcRejects as $reject_data)
                        <tr class="text-center">
                            <td>{{ $reject_data->iJobId }}</td>
                            
                            <td>{{ $reject_data->qty }}</td>
                            <td>{{ $reject_data->dBatch }}</td>
                            <td>{{ date('Y-m-d', strtotime($reject_data->dMfgDate)) }}</td>
                            <td class="text-center" style="vertical-align: middle;">
                                @if($reject_data->dMonthCreate == $month_now && $reject_data->dYearCreate == $year_now)
                                    <button onclick="editReject('{{ $reject_data->id }}')" class="btn btn-sm btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#modalEdit3">EDIT</button>
                                    <button onclick="deleteReject('{!!$reject_data->iJobId !!}','{!!$reject_data->dBatch !!}','{!!$reject_data->dMonthCreate !!}','{!!$reject_data->dYearCreate !!}')" class="btn btn-sm btn-danger mt-3">
                                        DELETE
                                    </button>
                                @else
                                    <span class="badge bg-danger">LOCKED</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL FOR EDITING --}}
<div class="modal fade" id="modalEdit3" tabindex="-1" aria-labelledby="modalEdit3Label" aria-hidden="true">
    <div class="modal-dialog"  style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modalEdit3Label">Edit Reject</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="row">
                <div class="col-sm-12">
                     <div class="card">
                        <div class="card-body">
                            <div class="container-fluid" style="padding:0px;">
                                <div class="row">
                                        <div class="col-sm-3">
                                        <label for="jobEdit">JOB</label>
                                        <input type="hidden" id="editRejectId">
                                        <select class="form-select" onchange="jobEdit(0)" name="jobEdit" id="jobEdit">
                                            <option value="" selected disabled>--SELECT JOB--</option>
                                            @foreach($jobs as $job)
                                                <option value="{{ $job->iJobNo }}">{{ $job->iJobNo }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="batches">BATCHES</label>
                                        <select class="form-select" name="editBatches" id="editBatches">
                                            <option value="" selected disabled>--SELECT BATCH--</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <br>
                                        <button type="button" class="btn btn-primary" style="width: 100%; margin-top:5px;" onclick="submitEditReject()">SAVE CHANGES</button>
                                    </div>
                                    <div class="col-sm-3">
                                        <br>
                                        <button type="button" class="btn btn-secondary" style="width: 100%; margin-top:5px;" data-bs-dismiss="modal">CLOSE</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-header text-center bg-primary">
                                    <h4 class="text-center text-white">CRITICAL</h4>
                                </div>
                                <div class="card-body">
                                    <div class="container-fluid" style="padding:0px;">
                                        <div class="row">
                                            <table class="table">
                                                <thead>
                                                    <tr class="text-center irene_thead">
                                                        <th style="width: 60%;"></th>
                                                        <th style="width: 40%;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="critical_body">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-header text-center bg-primary">
                                    <h4 class="text-center text-white">MINOR</h4>
                                </div>
                                <div class="card-body">
                                    <div class="container-fluid" style="padding:0px;">
                                        <div class="row">
                                            <table class="table">
                                                <thead>
                                                    <tr class="text-center irene_thead">
                                                        <th style="width: 60%;"></th>
                                                        <th style="width: 40%;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="minor_body">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-header text-center bg-primary">
                                    <h4 class="text-center text-white">MAJOR A</h4>
                                </div>
                                <div class="card-body">
                                    <div class="container-fluid" style="padding:0px;">
                                        <div class="row">
                                            <table class="table">
                                                <thead>
                                                    <tr class="text-center irene_thead">
                                                        <th style="width: 60%;"></th>
                                                        <th style="width: 40%;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="major_a_body">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-header text-center bg-primary">
                                    <h4 class="text-center text-white">MAJOR B</h4>
                                </div>
                                <div class="card-body">
                                    <div class="container-fluid" style="padding:0px;">
                                        <div class="row">
                                            <div class="row">
                                                <table class="table">
                                                    <thead>
                                                        <tr class="text-center irene_thead">
                                                            <th style="width: 60%;"></th>
                                                            <th style="width: 40%;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="major_b_body">
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              
            </div>
        </div>
    </div>
</div>
{{-- END MODAL EDIT --}}

{{-- MODAL FOR ADDING --}}
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog"  style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modalAddLabel">Add Reject</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="row">
                <div class="col-sm-12">
                     <div class="card">
                        <div class="card-body">
                            <div class="container-fluid" style="padding:0px;">
                                <div class="row">
                                        <div class="col-sm-3">
                                        <label for="jobAdd">JOB</label>
                                        <select class="form-select" onchange="jobAdd()" name="jobAdd" id="jobAdd">
                                            <option value="" selected disabled>--SELECT JOB--</option>
                                            @foreach($jobs as $job)
                                                <option value="{{ $job->iJobNo }}">{{ $job->iJobNo }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="batches">BATCHES</label>
                                        <select class="form-select" name="batches" id="batches">
                                            <option value="" selected disabled>--SELECT BATCH--</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <br>
                                        <button type="button" class="btn btn-primary" style="width: 100%; margin-top:5px;" onclick="submitAddReject()">SAVE CHANGES</button>
                                    </div>
                                    <div class="col-sm-3">
                                        <br>
                                        <button type="button" class="btn btn-secondary" style="width: 100%; margin-top:5px;" data-bs-dismiss="modal">CLOSE</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-header text-center bg-primary">
                                    <h4 class="text-center text-white">CRITICAL</h4>
                                </div>
                                <div class="card-body">
                                    <div class="container-fluid" style="padding:0px;">
                                        <div class="row">
                                            @foreach($criticals as $critical)
                                                <table class="table">
                                                    <tr>
                                                        <td style="width:60%; vertical-align: middle; text-align: left;">
                                                            <input class="rejectTypeStore" type="hidden" name="rejectTypeStore[]" value="{{ $critical->id }}">
                                                            <span style="font-size:12px; font-weight: bold; text-wrap: auto;">
                                                                {{ $critical->rejectName }}
                                                            </span>
                                                        </td>
                                                        <td style="width:40%; vertical-align: middle; text-align: left;">
                                                            <input onkeyup="updateIreneArrayStore('{{ $critical->id }}', this.value)" type="number" name="rejectQtyStore_{{ $critical->id }}" id="rejectQty_{{ $critical->id }}" value="0" min="0" max="99999999" class="form-control">
                                                        </td>
                                                    </tr>
                                                </table>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-header text-center bg-primary">
                                    <h4 class="text-center text-white">MINOR</h4>
                                </div>
                                <div class="card-body">
                                    <div class="container-fluid" style="padding:0px;">
                                        <div class="row">
                                            @foreach($minors as $minor)
                                                <table class="table">
                                                    <tr>
                                                        <td style="width:60%; vertical-align: middle; text-align: left;">
                                                            <input class="rejectTypeStore" type="hidden" name="rejectTypeStore[]" value="{{ $minor->id }}">
                                                            <span style="font-size:12px; font-weight: bold;     text-wrap: auto;">
                                                                {{ $minor->rejectName }}
                                                            </span>
                                                        </td>
                                                        <td style="width:40%; vertical-align: middle; text-align: left;">
                                                            <input onkeyup="updateIreneArrayStore('{{ $minor->id }}', this.value)" type="number" name="rejectQtyStore_{{ $minor->id }}" id="rejectQty_{{ $minor->id }}" value="0" min="0" max="99999999" class="form-control">
                                                        </td>
                                                    </tr>
                                                </table>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-header text-center bg-primary">
                                    <h4 class="text-center text-white">MAJOR A</h4>
                                </div>
                                <div class="card-body">
                                    <div class="container-fluid" style="padding:0px;">
                                        <div class="row">
                                            @foreach($majors_a as $major_a)
                                                <table class="table">
                                                    <tr>
                                                        <td style="width:60%; vertical-align: middle; text-align: left;">
                                                            <input class="rejectTypeStore" type="hidden" name="rejectTypeStore[]" value="{{ $major_a->id }}">
                                                            <span style="font-size:12px; font-weight: bold;     text-wrap: auto;">
                                                                {{ $major_a->rejectName }}
                                                            </span>
                                                        </td>
                                                        <td style="width:40%; vertical-align: middle; text-align: left;">
                                                            <input onkeyup="updateIreneArrayStore('{{ $major_a->id }}', this.value)" type="number" name="rejectQtyStore_{{ $major_a->id }}" id="rejectQty_{{ $major_a->id }}" value="0" min="0" max="99999999" class="form-control">
                                                        </td>
                                                    </tr>
                                                </table>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-header text-center bg-primary">
                                    <h4 class="text-center text-white">MAJOR B</h4>
                                </div>
                                <div class="card-body">
                                    <div class="container-fluid" style="padding:0px;">
                                        <div class="row">
                                            @foreach($majors_b as $major_b)
                                                <table class="table">
                                                    <tr>
                                                        <td style="width:60%; vertical-align: middle; text-align: left;">
                                                            <input class="rejectTypeStore" type="hidden" name="rejectTypeStore[]" value="{{ $major_b->id }}">
                                                            <span style="font-size:12px; font-weight: bold; text-wrap: auto;">
                                                                {{ $major_b->rejectName }}
                                                            </span>
                                                        </td>
                                                        <td style="width:40%; vertical-align: middle; text-align: left;">
                                                            <input onkeyup="updateIreneArrayStore('{{ $major_b->id }}', this.value)" type="number" name="rejectQtyStore_{{ $major_b->id }}" id="rejectQty_{{ $major_b->id }}" value="0" min="0" max="99999999" class="form-control">
                                                        </td>
                                                    </tr>
                                                </table>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              
            </div>
        </div>
    </div>
</div>
{{-- END MODAL ADD --}}


@endsection

@section('scripts')
<script src="{{asset('js/select2.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#rejectType').select2({
                dropdownParent: $('#modalAdd'),
                width: '100%'
            });
            $('#editRejectType').select2({
                dropdownParent: $('#modalEdit3'),
                width: '100%'
            });
        });
        function jobAdd(){
            var id = document.getElementById('jobAdd').value;
            $.ajax({
                url: '{{env("API_URL")}}/QcReject/batches/'+id,
                type: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                success: function(response){
                   console.log(response);
                   var batchesSelect = document.getElementById('batches');
                   batchesSelect.innerHTML = '<option value="" selected disabled>--SELECT BATCH--</option>';
                   response.forEach(function(batch){
                       var option = document.createElement('option');
                       option.value = batch.batches+'|'+batch.dMfgDate;
                       option.text = batch.batches;
                       batchesSelect.appendChild(option);
                   });
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }

        function jobEdit(batchPost){
            var id = document.getElementById('jobEdit').value;
            $.ajax({
                url: '{{env("API_URL")}}/QcReject/batches/'+id,
                type: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                success: function(response){
                   var batchesSelect = document.getElementById('editBatches');
                   batchesSelect.innerHTML = '<option value="" selected disabled>--SELECT BATCH--</option>';
                   response.forEach(function(batch){
                        if(batch.batches === batchPost){
                            var option = document.createElement('option');
                            option.value = batch.batches+'|'+batch.dMfgDate;
                            option.text = batch.batches;
                            option.selected = true;
                            batchesSelect.appendChild(option);
                            return;
                        }
                        var option = document.createElement('option');
                        option.value = batch.batches+'|'+batch.dMfgDate;
                        option.text = batch.batches;
                        batchesSelect.appendChild(option);
                   });
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }

        function submitAddReject(){
            var jobNo = document.getElementById('jobAdd').value;
            var batchData = document.getElementById('batches').value;
            let lengthReject = irene.length;

            if(!jobNo || !batchData || lengthReject == 0){
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "PLEASE FILL UP THE FIELDS",
                    showConfirmButton: false,
                    timer: 2500
                });
                return;
            }

            irene.forEach(function(rejectId){
               let quantity = document.getElementById('rejectQty_'+rejectId).value;
               let batchParts = batchData.split('|');
               let batchNo = batchParts[0];
               let mfgDate = batchParts[1];
               let dateNow = '{{ $date_now }}';
               let monthNow = '{{ $month_now }}';
               let yearNow = '{{ $year_now }}';
               let data = {
                   iJobId: jobNo,
                   dBatch: batchNo,
                   dMfgDate: mfgDate,
                   rejectId: rejectId,
                   qty: quantity,
                   dCreatedDate: dateNow,
                   dMonthCreate: monthNow,
                   dYearCreate: yearNow
               };

               $.ajax({
                   url: '{{env("API_URL")}}/QcRejectData',
                   type: 'POST',
                   headers: {
                       'Accept': 'application/json',
                       'Content-Type': 'application/json',
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   },
                   data: JSON.stringify(data),
                   success: function(response){
                   },
                   error: function(xhr){
                   }
               });
            });

            Swal.fire({
                position: "center",
                icon: "success",
                title: "REJECTS ADDED SUCCESSFULLY",
                showConfirmButton: false,
                timer: 2500
            });

            setTimeout(function(){
                location.reload();
            }, 2600);
        }

        function searchRejects(flag){
            let pages = document.getElementById('pages').value;
            let month = document.getElementById('month_select').value;
            let year = document.getElementById('year_select').value;
            if(flag === 1){
                pagesPost = 1;
            }else{
                pagesPost = pages;
            }
            $.ajax({
                url: '{{env("API_URL")}}/QcRejectData?dYearCreate='+year+'&dMonthCreate='+month+'&sortBy=true&pageNumber='+pagesPost+'&pageSize=10',
                type: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                success: function(response){
                    if(flag === 1){
                        currentPage = document.getElementById('pages').value;
                        $("#pages").empty();
                        for(let i=1; i<=response.pages; i++){
                            let selected = (i === currentPage) ? 'selected' : '';
                            let option = `<option ${selected} value="${i}">${i}</option>`;
                            $("#pages").append(option);
                        }
                    }

                    let tbody = document.getElementById('qc_rejects_table_body');
                    tbody.innerHTML = '';

                    response.qcRejects.forEach(function(item){
                        let badgeClass = '';
                        switch(item.reject.category.categoryName) {
                            case 'CRITICAL':
                                badgeClass = 'bg-danger';
                                break;
                            case 'MINOR':
                                badgeClass = 'bg-primary';
                                break;
                            case 'MAJOR A':
                                badgeClass = 'bg-warning';
                                break;
                            default:
                                badgeClass = 'bg-secondary';
                        }
                        if(item.dMonthCreate == '{{ $month_now }}' && item.dYearCreate == '{{ $year_now }}'){
                            var actionButtons = `
                                <button onclick="editReject('${item.id}')" class="btn btn-sm btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#modalEdit3">EDIT</button>
                                <button onclick="deleteReject('${item.iJobId}','${item.dBatch}','${item.dMonthCreate}','${item.dYearCreate}')" class="btn btn-sm btn-danger mt-3">
                                    DELETE
                                </button>
                            `;  
                        }else{
                            var actionButtons = `<span class="badge bg-danger">LOCKED</span>`;
                        }
                        let row = `
                                    <tr class="text-center">
                                        <td>${item.iJobId}</td>
                                        <td>
                                            <b>${item.reject.rejectName}</b>
                                            <br>
                                            <span class="badge ${badgeClass}">${item.reject.category.categoryName}</span>
                                        </td>
                                        <td>${item.qty}</td>
                                        <td>${item.dBatch}</td>
                                        <td>${item.dMfgDate.split('T')[0]}</td>
                                        <td>
                                            ${actionButtons}
                                        </td>
                                    </tr>
                        `;
                        tbody.innerHTML += row;
                    });
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }

        function editReject(id){
            var base_url = '{!! url("/") !!}';
            let rejectDataPost = {};
            ireneUpdate = [];
            Swal.fire({
                title: 'Loading...',
                timer: 4500,
                showCancelButton: false,
                showConfirmButton: false 
            });

            document.getElementById('editRejectId').value = id;

            $.ajax({
                url: '{{env("API_URL")}}/QcRejectData/'+id,
                type: 'GET',
                async: false,
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                success: function(rejectData){ 
                    document.getElementById('jobEdit').value = rejectData.iJobId;
                    jobEdit(rejectData.dBatch);
                    rejectDataPost = rejectData;
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
            
            $.ajax({
                url: '{{env("API_URL")}}/QcRejectData/by-group?iJobId=' + rejectDataPost.iJobId + '&dBatch=' + rejectDataPost.dBatch + '&dYearCreate=' + rejectDataPost.dYearCreate+ '&dMonthCreate=' + rejectDataPost.dMonthCreate,
                type: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                success: function(rejects){
                    document.querySelector('.critical_body').innerHTML = '';
                    document.querySelector('.minor_body').innerHTML = '';
                    document.querySelector('.major_a_body').innerHTML = '';
                    document.querySelector('.major_b_body').innerHTML = '';
                    rejects.forEach(function(reject){
                        if(reject.categoryName == 'CRITICAL'){
                            reject.qcDataFlags.forEach(function(data){
                                ireneUpdate.push(data.rejectId);
                                let row = `
                                            <tr>
                                                <td style="width:60%; vertical-align: middle; text-align: left;">
                                                    <span style="font-size:12px; font-weight: bold; text-wrap: auto;">
                                                        ${data.rejectName}
                                                    </span>
                                                </td>
                                                <td style="width:40%; vertical-align: middle; text-align: left;">
                                                    <input onkeyup="updateIreneArrayUpdate('${data.rejectId}', this.value)" type="number" name="rejectQtyEdit_${data.rejectId}" id="rejectQtyEdit_${data.rejectId}" value="${data.qty}" min="0" max="99999999" class="form-control">
                                                </td>
                                            </tr>
                                `;
                                document.querySelector('.critical_body').innerHTML += row;
                            });
                        }
                        if(reject.categoryName == 'MINOR'){
                            reject.qcDataFlags.forEach(function(data){
                                ireneUpdate.push(data.rejectId);
                                let row = `
                                            <tr>
                                                <td style="width:60%; vertical-align: middle; text-align: left;">
                                                    <span style="font-size:12px; font-weight: bold; text-wrap: auto;">
                                                        ${data.rejectName}
                                                    </span>
                                                </td>
                                                <td style="width:40%; vertical-align: middle; text-align: left;">
                                                    <input onkeyup="updateIreneArrayUpdate('${data.rejectId}', this.value)" type="number" name="rejectQtyEdit_${data.rejectId}" id="rejectQtyEdit_${data.rejectId}" value="${data.qty}" min="0" max="99999999" class="form-control">
                                                </td>
                                            </tr>
                                `;
                                document.querySelector('.minor_body').innerHTML += row;
                            });
                        }
                        if(reject.categoryName == 'MAJOR A'){
                            reject.qcDataFlags.forEach(function(data){
                                ireneUpdate.push(data.rejectId);
                                let row = `
                                            <tr>
                                                <td style="width:60%; vertical-align: middle; text-align: left;">
                                                    <span style="font-size:12px; font-weight: bold; text-wrap: auto;">
                                                        ${data.rejectName}
                                                    </span>
                                                </td>
                                                <td style="width:40%; vertical-align: middle; text-align: left;">
                                                    <input onkeyup="updateIreneArrayUpdate('${data.rejectId}', this.value)" type="number" name="rejectQtyEdit_${data.rejectId}" id="rejectQtyEdit_${data.rejectId}" value="${data.qty}" min="0" max="99999999" class="form-control">
                                                </td>
                                            </tr>
                                `;
                                document.querySelector('.major_a_body').innerHTML += row;
                            });
                        }
                        if(reject.categoryName == 'MAJOR B'){
                            reject.qcDataFlags.forEach(function(data){
                                ireneUpdate.push(data.rejectId);
                                let row = `
                                            <tr>
                                                <td style="width:60%; vertical-align: middle; text-align: left;">
                                                    <span style="font-size:12px; font-weight: bold; text-wrap: auto;">
                                                        ${data.rejectName}
                                                    </span>
                                                </td>
                                                <td style="width:40%; vertical-align: middle; text-align: left;">
                                                    <input onkeyup="updateIreneArrayUpdate('${data.rejectId}', this.value)" type="number" name="rejectQtyEdit_${data.rejectId}" id="rejectQtyEdit_${data.rejectId}" value="${data.qty}" min="0" max="99999999" class="form-control">
                                                </td>
                                            </tr>
                                `;
                                document.querySelector('.major_b_body').innerHTML += row;
                            });
                        }
                    });
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }


        function updateIreneArrayStore(rejectId, qty){
            if(qty <= 0 || qty === '' || qty === null){
                const itemToRemove = rejectId;
                const index = irene.indexOf(itemToRemove);
                if (index > -1) {
                    irene.splice(index, 1);
                }
               
            }else{
                if(irene.includes(rejectId)) {
                    console.log(rejectId + ' already in array');
                    return;
                }
                irene.push(rejectId);
            }
        }

        function updateIreneArrayUpdate(rejectId, qty){
            if(qty <= 0 || qty === '' || qty === null){
                const itemToRemove = rejectId;
                const index = ireneUpdate.indexOf(itemToRemove);
                if (index > -1) {
                    ireneUpdate.splice(index, 1);
                }
               
            }else{
                if(ireneUpdate.includes(rejectId)) {
                    console.log(rejectId + ' already in array');
                    return;
                }
                ireneUpdate.push(rejectId);
            }
        }

        function submitEditReject(){
            console.log(ireneUpdate);
            var jobNo = document.getElementById('jobEdit').value;
            var batchData = document.getElementById('editBatches').value;
            let lengthReject = ireneUpdate.length
            
            if(!jobNo || !batchData || lengthReject == 0){
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "PLEASE FILL UP THE FIELDS",
                    showConfirmButton: false,
                    timer: 2500
                });
                return;
            }
            
            $.ajax({
                url: '{{env("API_URL")}}/QcRejectData/by-group/delete?iJobId='+jobNo+'&dBatch='+batchData.split('|')[0]+'&dYearCreate={{ $year_now }}&dMonthCreate={{ $month_now }}',
                type: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                },
                error: function(xhr){
                }
            });
            Swal.fire({
                position: "center",
                icon: "success",
                title: "REJECTS UPDATED SUCCESSFULLY",
                showConfirmButton: false,
                timer: 3500
            });
            setTimeout(function(){
                ireneUpdate.forEach(function(rejectId){
                let quantity = document.getElementById('rejectQtyEdit_'+rejectId).value;
                let batchParts = batchData.split('|');
                let batchNo = batchParts[0];
                let mfgDate = batchParts[1];
                let dateNow = '{{ $date_now }}';
                let monthNow = '{{ $month_now }}';
                let yearNow = '{{ $year_now }}';
                let data = {
                    iJobId: jobNo,
                    dBatch: batchNo,
                    dMfgDate: mfgDate,
                    rejectId: rejectId,
                    qty: quantity,
                    dCreatedDate: dateNow,
                    dMonthCreate: monthNow,
                    dYearCreate: yearNow
                };

                $.ajax({
                    url: '{{env("API_URL")}}/QcRejectData',
                    type: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify(data),
                    success: function(response){
                    },
                    error: function(xhr){
                    }
                });
                });
            }, 2000);

            
            Swal.fire({
                position: "center",
                icon: "success",
                title: "REJECTS UPDATED SUCCESSFULLY",
                showConfirmButton: false,
                timer: 3500
            });
            setTimeout(function(){
                location.reload();
            }, 3600);

        }

        function deleteReject(jobId, batchNo, monthCreate, yearCreate){
            Swal.fire({
                title: 'Are you sure you want to delete this reject data?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{env("API_URL")}}/QcRejectData/by-group/delete?iJobId='+jobId+'&dBatch='+batchNo+'&dYearCreate='+yearCreate+'&dMonthCreate='+monthCreate,
                        type: 'DELETE',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response){
                            Swal.fire(
                                'Deleted!',
                                'The reject data has been deleted.',
                                'success'
                            );
                            setTimeout(function(){
                                location.reload();
                            }, 2000);
                        },
                        error: function(xhr){
                            console.log(xhr.responseText);
                        }
                    });
                }
            });
        }
    </script>
@endsection
