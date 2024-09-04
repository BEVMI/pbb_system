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
    REJECTS MODULE
@endsection 

@section('subtitle')
    LIST OF REJECTS
@endsection

@section('breadcrumbs_1')
    REJECT
@endsection

@section('breadcrumbs_2')
    LIST
@endsection

@section('button')
<button class="btn btn-primary mt-2 mt-xl-0" data-bs-toggle="modal" data-bs-target="#modalCreate" style="width:100%;">REJECT CREATE</button> 
@endsection

@section('main')
@endsection

@section('scripts')
@endsection