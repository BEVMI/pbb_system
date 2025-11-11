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
</style>
@endsection

@section('title') 
    QC REJECTS TYPE MODULE
@endsection 

@section('subtitle')
    LIST OF QC REJECTS TYPE 
    
@endsection

@section('breadcrumbs_1')
    QC REJECTS TYPE
@endsection

@section('breadcrumbs_2')
    LIST
@endsection

@section('button')
@endsection

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3">
            <label for="rejectName">Reject Name:</label>
            <input type="text" id="rejectName" class="form-control">
        </div>
        <div class="col-lg-3">
            <label for="rejectCode">Page:</label>
            <select onchange="searchRejects(0)" class="form-control" name="page" id="pages">
                @for($i=1; $i<=$response_resource->pages; $i++)
                    <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
        </div>
        <div class="col-lg-3">
            <br>
            <button onclick="searchRejects(1)" class="btn btn-primary mt-1">SEARCH</button>
        </div>
        <div class="col-lg-3"></div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-12">
            <table class="table table-bordered table-hover table-responsive-lg">
                <thead class="irene_thead">
                    <tr class="text-center">
                        <th style="width:40%;">REJECT TYPE</th>
                        <th style="width:40%;">CATEGORY</th>
                        <th style="width:20%;">ACTION</th>
                    </tr>
                </thead>
                <tbody id="qc_rejects_table_body">
                    <?php
                        $irene = '';
                    ?>
                    @foreach($response_resource->rejects as $item)
                        <tr class="text-center">
                            <td>{{ $item->rejectName }}</td>
                            @if($item->category->categoryName == 'CRITICAL')
                                <td><span class="badge bg-danger">{{ $item->category->categoryName }}</span></td>
                            @elseif($item->category->categoryName == 'MINOR')
                                <td><span class="badge bg-primary">{{ $item->category->categoryName }}</span></td>
                            @elseif($item->category->categoryName == 'MAJOR A')
                                <td><span class="badge bg-warning">{{ $item->category->categoryName }}</span></td>
                            @else
                                <td><span class="badge" style="background-color:rgb(172, 145, 70);">{{ $item->category->categoryName }}</span></td>
                            @endif
                            <td>
                                <button onclick="editReject('{!! $item->id !!}')" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEdit">EDIT</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL FOR EDITING --}}
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditLabel">Edit Reject Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editRejectForm">
          <div class="mb-3">
            <label for="editRejectName" class="form-label">Reject Name</label>
            <input type="text" class="form-control" id="editRejectName" name="rejectName" required>
          </div>
            <input type="hidden" id="editRejectId" name="id">
        </form>
      </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
            <button type="button" class="btn btn-primary" onclick="submitEditReject()">SAVE CHANGES</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        function searchRejects(flag){
            let pages = document.getElementById('pages').value;
            let rejectName = document.getElementById('rejectName').value;
            if(flag === 1){
                pagesPost = 1;
            }else{
                pagesPost = pages;
            }
            $.ajax({
                url: '{{env("API_URL")}}/QcReject?sortBy=true&pageNumber='+pagesPost+'&pageSize=10&rejectName='+rejectName,
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

                    response.rejects.forEach(function(item){
                        let badgeClass = '';
                        switch(item.category.categoryName) {
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
                        let row = `<tr class="text-center">
                                        <td>${item.rejectName}</td>
                                        <td><span class="badge ${badgeClass}">${item.category.categoryName}</span></td>
                                        <td><button onclick="editReject('${item.id}')" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEdit">EDIT</button></td>
                                    </tr>`;
                        tbody.innerHTML += row;
                    });
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }

        function editReject(id){
            $.ajax({
                url: '{{env("API_URL")}}/QcReject/'+id,
                type: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                success: function(response){
                    document.getElementById('editRejectName').value = response.rejectName;
                    document.getElementById('editRejectId').value = response.id;
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }

        function submitEditReject(){
            let id = document.getElementById('editRejectId').value;
            let rejectName = document.getElementById('editRejectName').value;
            $.ajax({
                url: '{{env("API_URL")}}/QcReject/'+id,
                type: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify({
                    rejectName: rejectName
                }),
                success: function(response){
                    $('#modalEdit').modal('hide');
                    Swal.fire(
                        'Success',
                        'Reject Type updated successfully',
                        'success'
                    );
                    searchRejects(0);
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }

    </script>
@endsection
