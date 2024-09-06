<div class="modal fade" data-bs-backdrop='static' id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold badge bg-primary" id="modalCreateLongTitle" style="font-size:16px;">FORECAST MIGRATION</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">  
                <div class='row'>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="forecast_upload">UPLOAD FORECAST</label>
                            <input style="padding-top: 11px; padding-left: 20px;" id="forecast_upload" class="form-control" type="file">
                        </div>

                    </div>    
                </div>
                
            </div>
            <div class="modal-footer">
                <button onclick="ireneCheck()" class="btn btn-success mt-2 mt-xl-0"style="width:100%;"                 data-bs-target="#finalize" data-bs-toggle="modal" data-bs-dismiss="modal">
                    CHECK
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
          <h5 class="modal-title" id="finalizeModalToggleLabel2">LIST OF STOCKCODES</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <input type="hidden" id="hidden_header_id">
                <table class="table text-center" id="table">
                    <thead class="irene_thead">
                        <th>ID</th>
                        <th>Stock Code</th>
                        <th>Description</th>
                        <th>Long Desc</th>
                        <th>Qty</th>
                        <th>Action</th>
                    </thead>
                    <tbody id="ireneTable4" class="text-center font-weight-bold">
                        
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">
                CLOSE
            </button>
        </div>
      </div>
    </div>
  </div>