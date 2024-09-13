<div class="modal fade" data-bs-backdrop='static' id="modalView" tabindex="-1" role="dialog" aria-labelledby="modalViewCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold badge bg-primary" id="modalViewLongTitle" style="font-size:16px;">PALLETS UPDATE</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">  
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input id="header_id" type="hidden">
                                <label for="status_post">STATUS:</label>
                                <select onchange='statusChange()' class="form-control"  id="status_post"></select>
                            </div>

                            <div class="form-group" id="reason_post_display">
                                <label for="reason_post">REASON:</label>
                                <textarea class="form-control" name="reason_post" id="reason_post"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="update_pallet" onclick="updatePallet()" class="btn btn-success mt-2 mt-xl-0">
                    UPDATE
                </button> 
            </div>
        </div>
    </div>
</div>


<div class="modal fade" data-bs-backdrop='static' id="modalPrint" tabindex="-1" role="dialog" aria-labelledby="modalPrintCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold badge bg-primary" id="modalPrintLongTitle" style="font-size:16px;">PALLETS PRINT</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">  
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>