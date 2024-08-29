@extends('layouts.main')

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .irene_thead {
        font-weight: bold;
        background-color: #5e72e4;
        color: white;
    }
</style>
@endsection

@section('title') 
    PLANS MODULE
@endsection 

@section('subtitle')
    LIST OF PLANS
@endsection

@section('breadcrumbs_1')
    Plan
@endsection

@section('breadcrumbs_2')
    List
@endsection

@section('button')
<button class="btn btn-primary mt-2 mt-xl-0" data-bs-toggle="modal" data-bs-target="#modalCreate" style="width:100%;">UPLOAD PLAN</button> 
@endsection

@section('main')
@include('includes.plan_modal')
@endsection

@section('scripts')
@include('api.plan')
@endsection