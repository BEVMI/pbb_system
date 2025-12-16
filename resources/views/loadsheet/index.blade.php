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
    td,th{
        vertical-align: middle;
    }
    .tooltip {
        z-index: 100000000; 
    }
    .invoiceAddBody tr td{
        word-wrap: break-word;
    }
    .nav.nav-pills .nav-link.active {
        animation: 0.2s ease;
        background: rgb(123, 142, 250);
        color: white;
    }
    .irene-table th, .irene-table td {
        text-align: center;
    }
</style>
@endsection

@section('title') 
    LOADSHEET MODULE
@endsection 

@section('subtitle')
    LIST OF LOADSHEET 
    
@endsection

@section('breadcrumbs_1')
    LOADSHEET
@endsection

@section('breadcrumbs_2')
    LIST
@endsection

@section('button')

@endsection

@section('main')
<script>
    let truckHeader = [];
    let truckDetails = [];
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3">
            <label for="rejectName">Month:</label>
        </div>
        <div class="col-lg-3">
            <label for="rejectCode">Year:</label>
        </div>
        <div class="col-lg-4">
            <br>
        </div>
        <div class="col-lg-2">
            <br>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd" style="width: 100%;">CREATE</button>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog"  style="max-width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modalAddLabel">ADD LOADSHEET</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <input type="hidden" id="yearNow" value="{{$year}}">
                <input type="hidden" id="monthNow" value="{{$month}}">
                <input type="hidden" id="dateToday" value="{{$date_today}}">
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="loadsheetMonth">CUSTOMER:</label>
                                        <select class="form-control" onchange="customerCheck()" id="loadsheetCustomer">
                                            <option value="">-- SELECT CUSTOMER --</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->customerID }}">{{ $customer->customerName }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-6">
                                        <label for="DEPOT">DEPOT</label>
                                        <select onchange="addLoadInvoices()" class="form-control" id="loadsheetDepot">
                                        </select>
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="add10Wheeler">10 WHEELER</label>
                                        <input type="number" class="form-control" id="add10Wheeler" min="0" value="0">
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="add6Wheeler">6 WHEELER</label>
                                        <input type="number" class="form-control" id="add6Wheeler" min="0" value="0">
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="add4Wheeler">4 WHEELER</label>
                                        <input type="number" class="form-control" id="add4Wheeler" min="0" value="0">
                                    </div>
                                    <div class="col-lg-12">
                                        <hr style="border:2px solid black;">
                                    </div>
                                    <div class="col-lg-12 pt-2">
                                        <div class="table-responsive" style="height: 400px; overflow-y: scroll;">
                                            <table class="table" id="invoiceAdd">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th style="width:20%;">PO</th>
                                                        <th style="width:20%;">SO</th>
                                                        <th style="width:40%;">
                                                            <input class="form-control" type="text" id="myInputAdd" onkeyup="searchAddTd()" placeholder="Search for Invoice..">
                                                        </th>
                                                        <th style="width:20%;">-</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="font-size: 14px;" id="invoiceAddBody">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 pt-5">
                                        <button id="allocateButton" onclick="loadTruck()" class="btn btn-success" style="width: 100%; display:none;">ALLOCATE TO TRUCK</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8">
                            <ul id="truckTabsCreate" class="nav nav-pills nav-justified">
                                
                            </ul>
                            <div class="tab-content" id="tabCreateTruckContent">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-8 pt-2">
                                
                            </div>
                            <div class="col-lg-2 pt-2">
                                <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">CLOSE</button>
                            </div>
                            <div class="col-lg-2 pt-2">
                                <button onclick="createLoadsheet()" class="btn btn-primary" style="width: 100%;">CREATE</button>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section ('scripts')
<script>
     function customerCheck(){
        var customer = $('#loadsheetCustomer').val();
        if(customer == ""){
            $('#loadsheetDepot').empty();
            $('#invoiceAddBody').empty();
            $('#allocateButton').hide();
            return;
        }
        $.ajax({
            url: '{{env("API_URL")}}/LoadSheetSyspro/depots/'+customer,
            type: 'GET',
            async: false,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            success: function(data){ 
                $('#loadsheetDepot').empty();
                $('#invoiceAddBody').empty();
                $('#loadsheetDepot').append('<option value="">-- SELECT DEPOT --</option>');
                $.each(data, function(key, value){
                    $('#loadsheetDepot').append('<option value="'+value.depotName+'">'+value.depotName+'</option>');
                });
            },
            error: function(xhr){
                console.log(xhr.responseText);
            }
        });
    }
    function loadTruck(){
        let add10Wheeler = document.getElementById('add10Wheeler').value;
        let add6Wheeler = document.getElementById('add6Wheeler').value;
        let add4Wheeler = document.getElementById('add4Wheeler').value;

        const checkedCheckboxes = document.querySelectorAll('.addInvoiceCheckbox:checked');

        if(checkedCheckboxes.length==0){
            Swal.fire({
                icon: 'error',
                title: 'PLEASE SELECT AT LEAST ONE INVOICE TO ALLOCATE',
            });
            return;
        }

        if(add10Wheeler == null || add10Wheeler == "" || isNaN(add10Wheeler) == true || parseInt(add10Wheeler) < 0){
            Swal.fire({
                icon: 'error',
                title: 'PLEASE ENTER VALID NUMBER OF 10 WHEELER TRUCKS',
            });
            return;
        }
        if(add6Wheeler == null || add6Wheeler == "" || isNaN(add6Wheeler) == true || parseInt(add6Wheeler) < 0){
            Swal.fire({
                icon: 'error',
                title: 'PLEASE ENTER VALID NUMBER OF 6 WHEELER TRUCKS',
            });
            return;
        }
        if(add4Wheeler == null || add4Wheeler == "" || isNaN(add4Wheeler) == true || parseInt(add4Wheeler) < 0){
            Swal.fire({
                icon: 'error',
                title: 'PLEASE ENTER VALID NUMBER OF 4 WHEELER TRUCKS',
            });
            return;
        }

        const checkedValues = Array.from(checkedCheckboxes).map(checkbox => checkbox.value);
        const separatedValues = checkedValues.join(",");

        let add10WheelerWeight = 13480;
        let add6WheelerWeight = 3480;
        let add4WheelerWeight = 6480;

        let add10Pallet = 16;
        let add6Pallet = 4;
        let add4Pallet = 8;
        truckHeader = [];
        
        let countDetail = 0;

        countTruck = 1;
        let ulCreateTruck = document.getElementById('truckTabsCreate');
        ulCreateTruck.innerHTML = '';

        let tabCreateTruckContent = document.getElementById('tabCreateTruckContent');
        tabCreateTruckContent.innerHTML = '';

        // DELETE PREVIOUS TEMP TRUCKS
        setTimeout(() => {
            $.ajax({
                url: '{{env("API_URL")}}/LoadSheetSyspro/trucks',
                type: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                success: function(response){
                    console.log('Previous temp trucks deleted');
                },
                error: function(xhr){
                }
            });
        }, 1000);

         setTimeout(() => {
            if(add10Wheeler > 0){
                for(let add10 = 0; add10 < add10Wheeler; add10++){
                    truckHeader.push(countTruck+'-10Wheeler');
                    let newLi = document.createElement('li');
                    let newDiv = document.createElement('div');
                    if(countTruck == 1){
                        newDiv.className = 'tab-pane fade show active';
                        newLi.innerHTML = '<a class="nav-link active" id="truck'+countTruck+'-tab" data-bs-toggle="tab" data-bs-target="#truck'+countTruck+'" type="button" role="tab" aria-controls="truck'+countTruck+'" aria-selected="true">TRUCK '+countTruck+'</a>';
                    } else {
                        newDiv.className = 'tab-pane fade';
                        newLi.innerHTML = '<a class="nav-link" id="truck'+countTruck+'-tab" data-bs-toggle="tab" data-bs-target="#truck'+countTruck+'" type="button" role="tab" aria-controls="truck'+countTruck+'" aria-selected="false">TRUCK '+countTruck+'</a>';
                    }
                    newDiv.id = 'truck'+countTruck;
                    newDiv.role = 'tabpanel';
                    newDiv.ariaLabelledby = 'truck'+countTruck+'-tab';
                    newDiv.innerHTML = '<div class="table-responsive" style="height: 600px; overflow-y: scroll;"><table class="table table-bordered irene-table"><thead><tr class="text-center irene_thead"><tr><th style="width:20%;">PO NUMBER</th><th style="width:15%;">INVOICE</th><th style="width:10%;">SKU</th><th style="width:25%;">DESCRIPTION</th><th style="style:width:10%;">UOM</th><th style="style:width:20%;">QTY</th></tr></thead><tbody id="truck'+countTruck+'Body"></tbody></table></div>';
                    document.querySelector('#tabCreateTruckContent').appendChild(newDiv);
                    document.querySelector('#truckTabsCreate').appendChild(newLi);
                    let data = {
                        truckNo: countTruck,
                        availablePallet: add10Pallet,
                        availableWeight: add10WheelerWeight
                    };
                    $.ajax({
                        url: '{{env("API_URL")}}/LoadSheetSyspro/trucks',
                        type: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        data: JSON.stringify(data),
                        success: function(response2){
                        },
                        error: function(xhr){
                        }
                    });
                    countTruck++;
                }
            }
            if(add6Wheeler > 0){
                for(let add6 = 0; add6 < add6Wheeler; add6++){
                    truckHeader.push(countTruck+'-6Wheeler');
                    let newLi = document.createElement('li');
                    let newDiv = document.createElement('div');
                    if(countTruck == 1){
                        newDiv.className = 'tab-pane fade show active';
                        newLi.innerHTML = '<a class="nav-link active" id="truck'+countTruck+'-tab" data-bs-toggle="tab" data-bs-target="#truck'+countTruck+'" type="button" role="tab" aria-controls="truck'+countTruck+'" aria-selected="true">TRUCK '+countTruck+'</a>';
                    } else {
                        newDiv.className = 'tab-pane fade';
                        newLi.innerHTML = '<a class="nav-link" id="truck'+countTruck+'-tab" data-bs-toggle="tab" data-bs-target="#truck'+countTruck+'" type="button" role="tab" aria-controls="truck'+countTruck+'" aria-selected="false">TRUCK '+countTruck+'</a>';
                    }
                    newDiv.id = 'truck'+countTruck;
                    newDiv.role = 'tabpanel';
                    newDiv.ariaLabelledby = 'truck'+countTruck+'-tab';
                    newDiv.innerHTML = '<div class="table-responsive" style="height: 600px; overflow-y: scroll;"><table class="table table-bordered irene-table"><thead><tr class="text-center irene_thead"><tr><th style="width:20%;">PO NUMBER</th><th style="width:15%;">INVOICE</th><th style="width:10%;">SKU</th><th style="width:25%;">DESCRIPTION</th><th style="style:width:10%;">UOM</th><th style="style:width:20%;">QTY</th></tr></thead><tbody id="truck'+countTruck+'Body"></tbody></table></div>';
                    
                    document.querySelector('#tabCreateTruckContent').appendChild(newDiv);
                    document.querySelector('#truckTabsCreate').appendChild(newLi);
                    let data = {
                        truckNo: countTruck,
                        availablePallet: add6Pallet,
                        availableWeight: add6WheelerWeight
                    };
                    $.ajax({
                        url: '{{env("API_URL")}}/LoadSheetSyspro/trucks',
                        type: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        data: JSON.stringify(data),
                    success: function(response2){
                    },
                    error: function(xhr){
                    }
                    });
                    countTruck++;
                }
            }
            if(add4Wheeler > 0){
                for(let add4 = 0; add4 < add4Wheeler; add4++){
                    truckHeader.push(countTruck+'-4Wheeler');
                    let newLi = document.createElement('li');
                    let newDiv = document.createElement('div');
                    if(countTruck == 1){
                        newDiv.className = 'tab-pane fade show active';
                        newLi.innerHTML = '<a class="nav-link active" id="truck'+countTruck+'-tab" data-bs-toggle="tab" data-bs-target="#truck'+countTruck+'" type="button" role="tab" aria-controls="truck'+countTruck+'" aria-selected="true">TRUCK '+countTruck+'</a>';
                    } else {
                        newDiv.className = 'tab-pane fade';
                        newLi.innerHTML = '<a class="nav-link" id="truck'+countTruck+'-tab" data-bs-toggle="tab" data-bs-target="#truck'+countTruck+'" type="button" role="tab" aria-controls="truck'+countTruck+'" aria-selected="false">TRUCK '+countTruck+'</a>';
                    }
                    newDiv.id = 'truck'+countTruck;
                    newDiv.role = 'tabpanel';
                    newDiv.ariaLabelledby = 'truck'+countTruck+'-tab';
                    newDiv.innerHTML = '<div class="table-responsive" style="height: 600px; overflow-y: scroll;"><table class="table table-bordered irene-table"><thead><tr class="text-center irene_thead"><tr><th style="width:20%;">PO NUMBER</th><th style="width:15%;">INVOICE</th><th style="width:10%;">SKU</th><th style="width:25%;">DESCRIPTION</th><th style="style:width:10%;">UOM</th><th style="style:width:20%;">QTY</th></tr></thead><tbody id="truck'+countTruck+'Body"></tbody></table></div>';
                    document.querySelector('#tabCreateTruckContent').appendChild(newDiv);
                    document.querySelector('#truckTabsCreate').appendChild(newLi);
                    let data = {
                        truckNo: countTruck,
                        availablePallet: add4Pallet,
                        availableWeight: add4WheelerWeight
                    };
                    $.ajax({
                    url: '{{env("API_URL")}}/LoadSheetSyspro/trucks',
                    type: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    data: JSON.stringify(data),
                    success: function(response2){
                    },
                    error: function(xhr){
                    }
                    });
                    countTruck++;
                }
            }
        }, 2000);

        let data = {
            invoices: separatedValues
        };
        truckDetails = [];
        setTimeout(() => {
            $.ajax({
                url: '{{env("API_URL")}}/LoadSheetSyspro/truckinvoices?truckNo=0',
                type: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                data: JSON.stringify(data),
                success: function(irene){
                    irene.forEach(function(invoice){
                        let newRow = document.createElement('tr');
                        let truckBodyId = 'truck'+invoice.truckNo+'Body';
                        newRow.innerHTML = '<td>'+invoice.customerPoNumber+'</td><td>'+invoice.invoice+'</td><td>'+invoice.stockCode+'</td><td>'+invoice.description+'</td><td>CS</td><td><input onkeyup="updateQty('+countDetail+')" id="qtyInput'+countDetail+'" class="form-control" type="number" value="'+invoice.qty+'"></td>';
                        document.getElementById(truckBodyId).appendChild(newRow);
                        countDetail++;
                        truckDetails.push(invoice);
                    });
                },
                error: function(xhr){
                }
            });  
        }, 3000);
    }

    function updateQty(detailIndex){
        let qtyInput = document.getElementById('qtyInput'+detailIndex).value;
        details[detailIndex].qty = parseInt(qtyInput);
    }

    function addLoadInvoices(){
        var customer = $('#loadsheetCustomer').val();
        var depot = $('#loadsheetDepot').val();
        $.ajax({
            url: '{{env("API_URL")}}/LoadSheetSyspro/arinvoices/'+customer+'/'+depot,
            type: 'GET',
            async: false,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            success: function(data){ 
                $('#invoiceAddBody').empty();
                if(data.length > 0){
                    $('#allocateButton').show();
                } else {
                    $('#allocateButton').hide();
                }
                $.each(data, function(key, value){
                    $('#invoiceAddBody').append('<tr class="text-center"><td>'+value.customerPoNumber+'</td><td>'+value.salesOrder+'</td><td>'+value.invoice+'</td><td><input class="addInvoiceCheckbox" type="checkbox" value="'+parseInt(value.invoice)+'"></td></tr>');
                });
            },
            error: function(xhr){
                $('#invoiceAddBody').empty();
                console.log(xhr.responseText);
            }
        });
    }

    function searchAddTd() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInputAdd");
        filter = input.value.toUpperCase();
        table = document.getElementById("invoiceAdd");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[2];
            if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
            }       
        }
    }

    function createLoadsheet(){
        let yearNow = document.getElementById('yearNow').value;
        let monthNow = document.getElementById('monthNow').value;
        let dateToday = document.getElementById('dateToday').value;
        let trucks = truckHeader;
        if(trucks.length == 0){
            Swal.fire({
                icon: 'error',
                title: 'PLEASE ALLOCATE INVOICES TO TRUCKS BEFORE CREATING LOADSHEET',
            });
            return;
        }
        
        // Header
        let customer = $('#loadsheetCustomer').val();
        let depot = $('#loadsheetDepot').val();
        let tenWheeler = $('#add10Wheeler').val();
        let sixWheeler = $('#add6Wheeler').val();
        let fourWheeler = $('#add4Wheeler').val();

        if(tenWheeler == null || tenWheeler == "" || isNaN(tenWheeler) == true || parseInt(tenWheeler) < 0){
           tenWheelerPost = 0;
        }else{
           tenWheelerPost = parseInt(tenWheeler);
        }
        if(sixWheeler == null || sixWheeler == "" || isNaN(sixWheeler) == true || parseInt(sixWheeler) < 0){
           sixWheelerPost = 0;
        }else{
           sixWheelerPost = parseInt(sixWheeler);
        }
        if(fourWheeler == null || fourWheeler == "" || isNaN(fourWheeler) == true || parseInt(fourWheeler) < 0){
           fourWheelerPost = 0;
        }else{
           fourWheelerPost = parseInt(fourWheeler);
        }
        Swal.fire({
            icon: 'success',
            title: 'LOADSHEET LOADING...',
            timer: 5000,
            showConfirmButton: false
        });
        $.ajax({
            url: '{{env("API_URL")}}/LssControlMaster/UpdateLssControlMaster/'+yearNow,
            type: 'PUT',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                },
            success: function(master){
                // MASTER
                let textConverted = master.sequence.toString().padStart(4, '0');
                let headerData = {
                    Customer : customer,
                    Depot : depot,
                    TenWheeler : tenWheelerPost,
                    SixWheeler : sixWheelerPost,
                    FourWheeler : fourWheelerPost, 
                    CreatedDate : dateToday,
                    MonthCreate: monthNow,
                    YearCreate: yearNow,
                    loadSheetNumber: "PBB-LSS-"+yearNow+"-"+textConverted
                };
                $.ajax({
                    url: '{{env("API_URL")}}/LssControlHeader/CreateLssHeader',
                    type: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        },
                    data: JSON.stringify(headerData),
                    success: function(response2){
                        console.log(response2);
                        // DetailHeader
                        let sequenceHeader = 1;
                        let userName = '{{ $user_auth->name }}';
                        trucks.forEach(function(truck){
                            let truckParts = truck.split('-');
                            let truckNo = truckParts[0];
                            let truckType = truckParts[1];

                            let HeaderDetailData = {
                                LssHeaderId : response2.id,
                                TruckType : truckType,
                                TruckSequence : sequenceHeader,
                                totalQty : 0,
                                Remarks : "-",
                                Damages : "-",
                                Excess : "-",
                                ShortReceive : "-",
                                Other : "-",
                                CrossDockCheckerFirst : "-",
                                CrossDockCheckerSecond : "-",
                                ApprovedBy : "-",
                                ApprovedDate : null,
                                CreatedBy : userName,
                                CreatedDate : dateToday,
                                Status : 0
                            };

                            $.ajax({
                                url: '{{env("API_URL")}}/LssControlHeaderDetail',
                                type: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                    },
                                data: JSON.stringify(HeaderDetailData),
                                success: function(response3){
                                    console.log(response3);
                                    // Detail
                                    truckDetails.forEach(function(detail){
                                        console.log(detail.truckNo + " == " + truckNo);
                                        if(detail.truckNo == truckNo){
                                            let DetailData = {
                                                LssDetailHeaderId : response3.id,
                                                Invoice : detail.invoice,
                                                StockCode : detail.stockCode,
                                                PalletNo : detail.palletNo,
                                                TruckNo : detail.truckNo,
                                                Qty : detail.qty,
                                                Customer : detail.customer,
                                                CustomerPoNumber : detail.customerPoNumber,
                                                MultiShipCode : detail.multiShipCode,
                                                CustomerName : detail.customerName,
                                                CaseCode : detail.caseCode,
                                                Description : detail.description,
                                            };
                                            $.ajax({
                                                url: '{{env("API_URL")}}/LssControlDetail/CreateLssDetail',
                                                type: 'POST',
                                                headers: {
                                                    'Accept': 'application/json',
                                                    'Content-Type': 'application/json',
                                                    },
                                                data: JSON.stringify(DetailData),
                                                success: function(response4){
                                                    console.log(response4);
                                                },
                                                error: function(xhr){
                                                }
                                            });
                                        }
                                    });
                                },
                                error: function(xhr){
                                }
                            });

                            sequenceHeader++;
                        });
                    },
                    error: function(xhr){
                    }
                });
            },
            error: function(xhr){
            }
        });
        setTimeout(() => {
            Swal.fire({
                icon: 'success',
                title: 'LOADSHEET CREATED SUCCESSFULLY',
                timer: 3000,
                showConfirmButton: false
            }).then(() => {
                location.reload();
            });
        }, 6000);
        // UPDATE CONTROL MASTER 
    }
   
</script>
@endsection