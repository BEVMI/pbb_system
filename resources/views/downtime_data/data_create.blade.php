<div class="row">
    <div class="col-12 text-end">
        <button class="badge bg-secondary">TOTAL MINUTES: <span id='irene2'>0</span></button>
    </div>
</div>
<div class="row">
    <div class="col-12 col-xl-12">
        <div class="list-group" id="myList" role="tablist" style="flex-direction:row;">
            <a class="list-group-item list-group-item-action active" data-toggle="list" href="#mcd" role="tab">
                <span id="mctotal" class="badge bg-secondary rounded-pill">0</span><br>
                MACHINE
            </a>
            <a class="list-group-item list-group-item-action" data-toggle="list" href="#exd" role="tab">
                <span id="extotal" class="badge bg-secondary rounded-pill">0</span><br>
                EXPECTED
            </a>
            <a class="list-group-item list-group-item-action" data-toggle="list" href="#uexd" role="tab">
                <span id="uextotal" class="badge bg-secondary rounded-pill">0</span><br>
                UNEXPECTED
            </a>
        </div>
    </div>
    <div class="col-12 col-xl-12 mt-2">
        <div class="tab-content" style="height: 500px;overflow-x: scroll;">
            <div class="tab-pane fade active show" id="mcd" role="tabpanel">
                @include('table_downtime.machine')
            </div>
            <div class="tab-pane fade" id="exd" role="tabpanel">
                @include('table_downtime.expected')
            </div>
            <div class="tab-pane fade" id="uexd" role="tabpanel">
                @include('table_downtime.unexpected')
            </div>
        </div>
    </div>
</div>