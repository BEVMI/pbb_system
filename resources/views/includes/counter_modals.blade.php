<div class="modal fade" data-bs-backdrop='static' id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered irene_modal"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold badge bg-primary" id="modalCreateLongTitle" style="font-size:16px;">COUNTER CREATION</h5>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-8">

                        </div>
                        <div class="col-xl-2">
                            <button id="post_counter" onclick="postCounter()" class="btn btn-success mt-2 mt-xl-0" style="width:100%; display:none;">
                                SAVE
                            </button> 
                        </div>
                        <div class="col-xl-2">
                            <button class="btn btn-outline-secondary" class="close" data-bs-dismiss="modal" aria-label="Close" style="width:100%; ">
                                CLOSE
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">  
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="card text-center">
                                <div class="font-weight-bold card-header bg-primary text-white">
                                    MACHINE COUNTER
                                </div>
                                <div class="card-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="lines">LINE:</label>
                                                    <select onchange="hideFields()" class="form-control" name="lines" id="lines">
                                                        @foreach ($lines as $line)
                                                            <option value="{{$line->id}}">{{$line->cDescription}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="job_number">JOB</label>
                                                    <select onchange="hideFields()" class="form-control" name="job_number" id="job_number">
                                                        @foreach ($jobs as $job)
                                                            <option value="{{$job->value}}">{{$job->text}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="iLossPallet">LOSS CASE</label>
                                                    <input type="number" value="0" min="0" max="99999" class="form-control" name="iLossPallet" id="iLossPallet">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="lines">COUNTER DATE:</label>
                                                <input class="form-control" id="date_counter" type="date" value="{{$initial_date}}">
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="job_date">FBO:</label>
                                                    <input class="form-control" type="time" id="FBO" name="appt">
                                                </div>
                                            </div>
                    
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="job_date">LBO:</label>
                                                    <input class="form-control" type="time" id="LBO" name="appt">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button onclick="choose_line()" class="btn btn-outline-success" style="margin-top:3px; width:100%;">CHOOSE</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead class="irene_thead text-center">
                                                            <th class="col" style="width:50%;">SECTION</th>
                                                            <th class="col" style="width:25%;">IN</th>
                                                            <th class="col" style="width:25%;">OUT</th>
                                                        </thead>
                                                        <tbody id="counter_body" class="text-center" style="font-size: 11px;">
                    
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card text-center">
                                <div class="font-weight-bold card-header bg-primary text-white">
                                    DOWNTIME
                                </div>
                                <div class="card-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="shift_length">SHIFT LENGTH</label>
                                                    <input type="number" value="0" min="0" max="99999" class="form-control" name="shiftLength" id="shiftLength">
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="shift_length">FG CASES</label>
                                                    <input type="number" value="0" min="0" max="99999" class="form-control" name="dFgCases" id="dFgCases">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                @include('downtime_data.data_create')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card text-center">
                                <div class="font-weight-bold card-header bg-primary text-white">
                                    REJECTS
                                </div>
                                <div class="card-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12" style="display: none;">
                                                <div class="form-group">
                                                    <label for="iLossPalletReject">LOSS CASE</label>
                                                    <input type="number" value="0" min="0" max="99999" class="form-control" name="iLossPalletReject" id="iLossPalletReject">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="table-reponsive">
                                                            <table class="table">
                                                                <thead class="irene_thead text-center">
                                                                    <th class="col">SECTION</th>
                                                                    <th class="col">MATERIALS</th>
                                                                    <th class="col">QTY</th>
                                                                </thead>
                                                                <tbody id="reject_body" class="text-center" style="font-size: 11px;">
                            
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-bs-backdrop='static' id="finalize" aria-hidden="true" aria-labelledby="finalizeModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="finalizeModalToggleLabel2">FINALIZE FORECAST</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table" id="table">
                    <tbody id="ireneTable2" class="text-center font-weight-bold">
                        
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-target="#modalCreate" data-bs-toggle="modal" data-bs-dismiss="modal">GO BACK</button>
          <button onclick="ireneUpload()" class="btn btn-success mt-2 mt-xl-0 loading_button">
                UPLOAD
           </button> 
        </div>
      </div>
    </div>
</div>
