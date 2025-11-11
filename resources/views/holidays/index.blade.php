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
            <label for="year_search">YEAR</label>
            <select class="form-control" id="year_search" name="year_search" onchange="searchRejects(0)">
                @for($year = 2025; $year <= 2050; $year++)
                    <option value="{{ $year }}" {{ $year == $year_now ? 'selected' : '' }}>{{ $year }}</option>
                @endfor
            </select>
        </div>
        <div class="col-lg-3">
            <label for="rejectCode">Page:</label>
            <select onchange="searchRejects(1)" class="form-control" name="page" id="pages">
                @for($i=1; $i<=$pages; $i++)
                    <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
        </div>
        <div class="col-lg-4">
            <br>
          
        </div>
        <div class="col-lg-2">
            <br>
            <button class="btn btn-primary" style="width:100% ;" data-bs-toggle="modal" data-bs-target="#modalAdd">ADD HOLIDAY</button>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-12">
            <table class="table table-bordered table-hover table-responsive-lg">
                <thead class="irene_thead">
                    <tr class="text-center">
                        <th style="width:40%;">HOLIDAY</th>
                        <th style="width:40%;">DATE</th>
                        <th style="width:20%;">ACTION</th>
                    </tr>
                </thead>
                <tbody id="holiday_table_body">
                    @if(count($holidays) == 0)
                        <tr>
                            <td colspan="3" class="text-center">NO HOLIDAYS ADDED</td>
                        </tr>
                    @else
                        @foreach($holidays as $item)
                            <tr class="text-center">
                                <td>{{ $item->holidayName }}</td>
                                <td>{{ date('F d, Y', strtotime($item->date)) }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit" onclick="editHoliday('{{ $item->id }}', '{{ $item->holidayName }}', '{{ $item->date }}')">EDIT</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteHoliday('{{ $item->id }}')">DELETE</button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ADD HOLIDAY MODAL --}}
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ADD HOLIDAY</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="holiday_name" class="form-label">HOLIDAY NAME</label>
                    <input type="text" class="form-control" id="holiday_name">
                </div>
                <div class="mb-3">
                    <label for="holiday_from" class="form-label">HOLIDAY FROM</label>
                    <input type="date" value="{{$date_today}}" class="form-control" id="holiday_from">
                </div>
                <div class="mb-3">
                    <label for="holiday_to" class="form-label">HOLIDAY TO</label>
                    <input type="date" value="{{$date_today}}" class="form-control" id="holiday_to">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
                <button type="button" class="btn btn-primary" onclick="addHoliday()">SAVE HOLIDAY</button>
            </div>
        </div>
    </div>
</div>

{{-- EDIT HOLIDAY MODAL --}}
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EDIT HOLIDAY</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="hidden" id="edit_holiday_id">
                    <label for="edit_holiday_name" class="form-label">HOLIDAY NAME</label>
                    <input type="text" class="form-control" id="edit_holiday_name">
                </div>
                <div class="mb-3">
                    <label for="edit_holiday_to" class="form-label">HOLIDAY DATE</label>
                    <input type="date" class="form-control" id="edit_holiday">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
                <button type="button" class="btn btn-primary" onclick="updateHoliday()">SAVE CHANGES</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script>
        function searchRejects(flag){
            let year = document.getElementById('year_search').value;
            let pagesPost = 1;
            if(flag === 1){
                pagesPost = document.getElementById('pages').value;
            }
            else{
                pagesPost = 1;
            }
            $.ajax({
                url: '{{env("API_URL")}}/Holiday?sortBy=false&pageNumber='+pagesPost+'&pageSize=10&year='+year,
                type: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                success: function(response){
                    if(flag === 0){
                        currentPage = document.getElementById('pages').value;
                        $("#pages").empty();
                        for(let i=1; i<=response.pages; i++){
                            let selected = (i === currentPage) ? 'selected' : '';
                            let option = `<option ${selected} value="${i}">${i}</option>`;
                            $("#pages").append(option);
                        }
                    }

                    $("#holiday_table_body").empty();
                    if(response.holidays.length == 0){
                        let row = `<tr>
                                        <td colspan="3" class="text-center">NO HOLIDAYS ADDED</td>
                                    </tr>`;
                        $("#holiday_table_body").append(row);
                    }else{
                        response.holidays.forEach(function(item){
                            let formattedDate = new Date(item.date);
                            let options = { year: 'numeric', month: 'long', day: 'numeric' };
                            let dateString = formattedDate.toLocaleDateString('en-US', options);

                            let row = `<tr class="text-center">
                                            <td>${item.holidayName}</td>
                                            <td>${dateString}</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit" onclick="editHoliday('${item.id}', '${item.holidayName}', '${item.date}')">EDIT</button>
                                                <button class="btn btn-danger btn-sm" onclick="deleteHoliday('${item.id}')">DELETE</button>
                                            </td>
                                        </tr>`;
                            $("#holiday_table_body").append(row);
                        });
                    }
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }
        function addHoliday(){
            let holiday_name = document.getElementById('holiday_name').value;
            let holiday_from = document.getElementById('holiday_from').value;
            let holiday_to = document.getElementById('holiday_to').value;

            if(holiday_name == '' || holiday_from == '' || holiday_to == ''){
                swal.fire(
                    'INCOMPLETE DATA',
                    'PLEASE FILL OUT ALL FIELDS',
                    'warning',
                );
                return;
            }
            let diffDays = (new Date(holiday_to) - new Date(holiday_from)) / (1000 * 60 * 60 * 24);
            if(diffDays < 0){
                swal.fire(
                    'INVALID DATE RANGE',
                    'HOLIDAY TO DATE MUST BE GREATER THAN OR EQUAL TO HOLIDAY FROM DATE',
                    'warning',
                );
                return;
            }
            let diffDaysInt = parseInt(diffDays) + 2;
            for(x=1; x<diffDaysInt; x++){
                let plusOneDay = new Date(holiday_from);
                plusOneDay.setDate(plusOneDay.getDate() + (x - 1));
                let month = '' + (plusOneDay.getMonth() + 1);
                let day = '' + plusOneDay.getDate();
                let year = plusOneDay.getFullYear();
                if(month.length < 2) month = '0' + month;
                if(day.length < 2) day = '0' + day;
                let formattedDate = year + '-' + month + '-' + day;
                
                let data = {
                    holidayName: holiday_name,
                    Date: formattedDate
                };

                $.ajax({
                    url:'{{env("API_URL")}}/Holiday/date/'+formattedDate,
                    type: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    success: function(response){
                        if(response === 1){             
                            $.ajax({
                                url: '{{env("API_URL")}}/Holiday',
                                type: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                },
                                data: JSON.stringify(data),
                                success: function(response){

                                },
                                error: function(xhr){
                                    console.log(xhr.responseText);
                                }
                            });
                        }
                    },
                });

            }
            setTimeout(() => {
                swal.fire(
                    'SUCCESS',
                    'HOLIDAY ADDED SUCCESSFULLY',
                    'success',
                );
            }, 1000);

            setTimeout(() => {
                location.reload();
            }, 2000);
        }

        function editHoliday(id, name, date){
            document.getElementById('edit_holiday_name').value = name;
            formattedDate = date.split('T')[0];
            document.getElementById('edit_holiday').value = formattedDate;
            document.getElementById('edit_holiday_id').value = id;
        }

        function updateHoliday(){
            let id = document.getElementById('edit_holiday_id').value;
            let holiday_name = document.getElementById('edit_holiday_name').value;
            let holiday_date = document.getElementById('edit_holiday').value;

            if(holiday_name == '' || holiday_date == ''){
                swal.fire(
                    'INCOMPLETE DATA',
                    'PLEASE FILL OUT ALL FIELDS',
                    'warning',
                );
                return;
            }

            let data = {
                holidayName: holiday_name,
                Date: holiday_date
            };

            $.ajax({
                url: '{{env("API_URL")}}/Holiday/'+id,
                type: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                data: JSON.stringify(data),
                success: function(response){
                    $('#modalEdit').modal('hide');
                    swal.fire(
                        'SUCCESS',
                        'HOLIDAY UPDATED SUCCESSFULLY',
                        'success',
                    );
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                    swal.fire(
                        'ERROR',
                        xhr.responseText,
                        'error',
                    );
                }
            });

        }

        function deleteHoliday(id){
            Swal.fire({
                title: 'ARE YOU SURE?',
                text: "YOU WON'T BE ABLE TO REVERT THIS!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'YES, DELETE IT!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{env("API_URL")}}/Holiday/'+id,
                        type: 'DELETE',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        success: function(response){
                            Swal.fire(
                                'DELETED!',
                                'HOLIDAY HAS BEEN DELETED.',
                                'success'
                            );
                            setTimeout(() => {
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
