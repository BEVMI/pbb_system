<?php 
$user_auth = Auth::user();
$layout = session('pms_pbb_design');
if($layout == 1):
    $layout_post = 'main';
else:
    $layout_post = 'main1';
endif;
?>

@extends('layouts.'.$layout_post)

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
   
    td{
        vertical-align: middle;
    }
    .list-group-item.active {
        z-index: 2;
        color: white;
        background-color: #212529;
        border-color: #212529;
    }
    .irene_thead {
        font-weight: bold;
        background-color: #5e72e4;
        color: white;
    }
    td{
        vertical-align: middle;
    }
    .irene_modal{
        min-width:1620px; 
    }
    .input[type=text],input[type=number],input[type=time],input[type=date]{
        height: 30px;
    }
    .modal-dialog {
        height: 100%; /* = 90% of the .modal-backdrop block = %90 of the screen */
    }
    .modal-content {
        height: 100%; /* = 100% of the .modal-dialog block */
    }
    @media (max-width: 1320px) {
        .irene_modal{
            min-width:100%;
        }
    }
</style>
@endsection

@section('title') 
    MACHINE COUNTER MODULE
@endsection 

@section('subtitle')
    LIST OF MACHINE COUNTER
@endsection

@section('breadcrumbs_1')
    MACHINE COUNTER
@endsection

@section('breadcrumbs_2')
    LIST
@endsection

@section('button')
<button class="btn btn-primary mt-2 mt-xl-0" data-bs-toggle="modal" data-bs-target="#modalCreate" onclick="reset()" style="width:100%;">CREATE</button> 
@endsection

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-4 col-12"></div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <label for="line_search">LINES</label>
            <select onchange="hideFields()" class="form-control" name="line_search" id="line_search">
                @foreach ($lines as $line)
                    <option value="{{$line->id}}">{{$line->cDescription}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <label for="month_now">MONTH FILTER</label>
            <select id="month_now" class="form-control">
                @foreach ($months as $month)
                    @if($month->month_number == $month_now)
                        <option selected value="{{$month->month_number}}">{{$month->month_name}}</option>
                    @else
                        <option value="{{$month->month_number}}">{{$month->month_name}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <div class="form-group">
                <label for="year_now">YEAR</label>
                <input class="form-control" id='year_now' type="number" value="{{$year_now}}">
            </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <br>
            <button onclick='search()' type="button" class="btn btn-outline-success" style="margin-top:3px; width:100%;">FILTER</button>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive" style="height:60vh; overflow:auto;">
            <table class="table">
                <thead class="text-center irene_thead">
                    <th style="width: 20%">LINEID#</th>
                    <th style="width: 20%">JOB#</th>
                    <th style="width: 20%">DATE</th>
                    <th style="width: 20%">ENCODED BY</th>
                    <th style="width: 20%">ACTION</th>
                </thead>
                <tbody class="text-center" id="machine_body_table">

                </tbody>
            </table>
        </div>
    </div>
</div>
@include('includes.counter_modals')
@endsection

@section('scripts')
@include('api.counter')
@include('api.counter2')
<script>
    var triggerTabList = [].slice.call(document.querySelectorAll('#myList a'))
triggerTabList.forEach(function (triggerEl) {
  var tabTrigger = new bootstrap.Tab(triggerEl)

  triggerEl.addEventListener('click', function (event) {
    event.preventDefault()
    tabTrigger.show()
  })
})
</script>
@endsection