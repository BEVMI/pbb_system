<div class="modal fade" data-bs-backdrop='static' id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold badge bg-primary" id="modalCreateLongTitle" style="font-size:16px;">COUNTER CREATION</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">  
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
                                <select onchange="hideJob()" class="form-control" name="job_number" id="job_number">
                                    @foreach ($jobs as $job)
                                        <option value="{{$job}}">{{$job}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="lines">DATE:</label>
                            <input class="form-control" id="date_counter" type="date" value="{{$initial_date}}">
                        </div>
                        <div class="col-6">
                            <br>
                            <button onclick="choose_line()" class="btn btn-outline-success" style="margin-top:3px; width:100%;">CHOOSE</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-reponsive">
                                <table class="table">
                                    <thead class="irene_thead text-center">
                                        <th class="col">SECTION</th>
                                        <th class="col">IN</th>
                                        <th class="col">OUT</th>
                                    </thead>
                                    <tbody id="counter_body" class="text-center">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="post_counter" onclick="postCounter()" class="btn btn-success mt-2 mt-xl-0" style="display:none;">
                    SAVE
                </button> 
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

<div class="modal fade" data-bs-backdrop='static' id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="finalizeModalToggleLabel2">DETAIL</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="hidden_header_id">
                <input id="date_update" type="hidden">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="lines_update">LINE:</label>
                                <select class="form-control" name="lines_update" id="lines_update">
                                    @foreach ($lines as $line)
                                        <option value="{{$line->id}}">{{$line->cDescription}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="job_number_update">JOB</label>
                                <select class="form-control" name="job_number_update" id="job_number_update">
                                    @foreach ($jobs as $job)
                                        <option value="{{$job}}">{{$job}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-reponsive">
                                <table class="table">
                                    <thead class="irene_thead text-center">
                                        <th class="col">SECTION</th>
                                        <th class="col">IN</th>
                                        <th class="col">OUT</th>
                                    </thead>
                                    <tbody id="counter_body_update" class="text-center">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="updateCounter()">
                    UPDATE
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">
                    CLOSE
                </button>
            </div>
        </div>
    </div>
</div>