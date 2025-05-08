<div class="row">
    <div class="col-12 text-end">
        <button class="badge bg-secondary">TOTAL MINUTES: <span id='irene3'>0</span></button>
    </div>
</div>
<div class="row">
    <div class="col-12 col-xl-12">
        <div class="list-group" id="myList1" role="tablist" style="flex-direction:row;">
            <a class="list-group-item list-group-item-action active" data-toggle="list" href="#update_mcd" role="tab">
                <span id="mctotal_update" class="badge bg-secondary rounded-pill">0</span><br>
                MACHINE
            </a>
            <a class="list-group-item list-group-item-action" data-toggle="list" href="#update_exd" rolu="tab">
                <span id="extotal_update" class="badge bg-secondary rounded-pill">0</span><br>
                EXPECTED
            </a>
            <a class="list-group-item list-group-item-action" data-toggle="list" href="#update_uexd" role="tab">
                <span id="uextotal_update" class="badge bg-secondary rounded-pill">0</span><br>
                UNEXPECTED
            </a>
        </div>
    </div>
    <div class="col-12 col-xl-12 mt-2">
        <div class="tab-content" style="height: 500px;overflow-x: scroll;">
            <div class="tab-pane fade active show" id="update_mcd" role="tabpanel">
                @include('table_downtime.machine_update')
            </div>
            <div class="tab-pane fade" id="update_exd" role="tabpanel">
                @include('table_downtime.expected_update')
            </div>
            <div class="tab-pane fade" id="update_uexd" role="tabpanel">
                @include('table_downtime.unexpected_update')
            </div>
        </div>
    </div>
</div>