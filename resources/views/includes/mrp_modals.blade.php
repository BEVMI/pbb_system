<div class="modal fade" data-bs-backdrop='static' id="modalMRP" tabindex="-1" role="dialog" aria-labelledby="modalCreateCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold badge bg-primary" id="planTitle" style="font-size:16px;">COMPUTE MATERIALS</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">  
               <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="month_now">MONTH FILTER</label>
                            <select id="month_now" class="form-control">
                                <option value="1">JANUARY</option>
                                <option value="2">FEBRUARY</option>
                                <option value="3">MARCH</option>
                                <option value="4">APRIL</option>
                                <option value="5">MAY</option>
                                <option value="6">JUNE</option>
                                <option value="7">JULY</option>
                                <option value="8">AUGUST</option>
                                <option value="9">SEPTEMBER</option>
                                <option value="10">OCTOBER</option>
                                <option value="11">NOVEMBER</option>
                                <option value="12">DECEMBER</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="year">YEAR</label>
                            <input class="form-control" id='year_now' type="number" value="{{$year_now}}">
                        </div>

                        <div class="form-group">
                            <label for="source">SOURCE</label>
                            <select class="form-control" name="source" id="source">
                                <option value="Plan">PLAN</option>
                                <option value="Forecast">FORECAST</option>
                            </select>
                        </div>
                    </div>
               </div>
            </div>
            <div class="modal-footer">
                <button onclick="computeMaterials()" class="btn btn-outline-success" class="btn btn-outline-success">
                    COMPUTE
                </button>
                <button class="btn btn-outline-secondary" class="close" data-bs-dismiss="modal" aria-label="Close">
                    CLOSE
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-bs-backdrop='static' id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="finalizeModalToggleLabel2">DATE OF DELIVERY/REMARKS</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="post_stockcode">STOCK CODE</label>
                <input class="form-control" id="post_stockcode" type="text" readonly>
            </div>
            <div class="form-group">
                <label for="post_dDeliveryDate">DELIVERY DATE</label>
                <input class="form-control" id="post_dDeliveryDate" type="date">
            </div>

            <div class="form-group">
                <label for="post_cRemarks">REMARKS</label>
                <textarea class="form-control" id="post_cRemarks"></textarea>
            </div>
                
        </div>
        <div class="modal-footer">
            <button type="button" onclick="updateMrp()" class="btn btn-success">SAVE</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">
                CLOSE
            </button>
        </div>
      </div>
    </div>
  </div>