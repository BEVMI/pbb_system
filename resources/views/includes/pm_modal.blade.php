<div class="modal fade" data-bs-backdrop='static' id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalCreateCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold badge bg-primary" id="planTitle" style="font-size:16px;">PM DETAIL</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">  
               <div class="row" style="padding: 10px;">
                    <input type="hidden" id="plan_id">
                    <div class="form-group">
                        <label for="remarks_pm">PM REMARKS</label>
                        <textarea class="form-control" id="pm_remarks">

                        </textarea>
                    </div>
                    <button class="btn btn-outline-success" onclick="approvePM()">
                        SAVE
                    </button>
                    <button class="btn btn-outline-secondary" class="close" data-bs-dismiss="modal" aria-label="Close">
                        CLOSE
                    </button>
               </div>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>


<div class="modal fade" data-bs-backdrop='static' id="modalMassPm" tabindex="-1" role="dialog" aria-labelledby="modalMassPmCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold badge bg-primary" id="planTitle" style="font-size:16px;">PM MASS APPROVE</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">  
                <div class="row">
                    <div class="col-sm-12">
                        <label for="mass_date_from">FROM</label>
                        <input class="form-control" type="date" id="mass_date_from">
                    </div>
                    <div class="col-sm-12">
                        <label for="mass_date_from">TO</label>
                        <input class="form-control" type="date" id="mass_date_to">
                    </div>
                </div>
               <div class="row" style="padding: 10px;">
                    <input type="hidden" id="plan_id">
                    <div class="form-group">
                        <label for="remarks_mass_pm">PM REMARKS</label>
                        <textarea class="form-control" id="pm_mass_remarks"></textarea>
                    </div>
                    <button class="btn btn-outline-success" onclick="approveMassPM()">
                        SAVE
                    </button>
                    <button class="btn btn-outline-secondary" class="close" data-bs-dismiss="modal" aria-label="Close">
                        CLOSE
                    </button>
               </div>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>