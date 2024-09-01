<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold badge bg-primary" id="modalCreateLongTitle" style="font-size:16px;">PLAN UPLOAD</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">  
                <div class='row'>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="month_upload">MONTH FILTER</label>
                            <select id="month_upload" class="form-control">
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
                            <div class="form-group">
                                <label for="year">YEAR</label>
                                <input class="form-control" id='year_now' type="number" value="{{$year_now}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label for="line">LINE</label>
                                <select id="line" class="form-control">
                                    @if($line == 1)
                                        <option value="1">LINE 1</option>
                                    @elseif($line==2)
                                        <option value="2">LINE 2</option>
                                    @elseif($line=='3')
                                        <option value="3">INJECTION</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="forecast_upload">UPLOAD PLAN</label>
                            <input style="padding-top: 11px; padding-left: 20px;" id="plan_upload" class="form-control" type="file">
                        </div>
                    </div>    
                </div>
                
            </div>
            <div class="modal-footer">
                <button onclick="uploadPlan()" class="btn btn-success mt-2 mt-xl-0"style="width:100%;">
                    UPLOAD
                </button> 
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalCreateCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold badge bg-primary" id="planTitle" style="font-size:16px;">PLAN DETAILS</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">  
                <div class="row">
                    <div class="col-xl-6 col-12">
                        <h5 class="text-center">CREATION OF PLAN</h5>
                        <div class="form-group">
                            <label for="stock_codes_create">STOCK CODE:</label>
                            <select class="form-control" name="stock_codes_create" id="stock_codes_create">
                                @foreach($stock_codes as $stock_code)
                                    <option value="{{$stock_code}}">{{$stock_code}}</option>
                                @endforeach
                            </select> 
                        </div>
                        
                    </div>
                    <div class="col-xl-6 col-12">
                        <h5 class="text-center">UPDATE OF PLAN</h5>
                        <div class="form-group">
                            <label for="stock_codes_update">STOCK CODE:</label>
                            <select onchange="updateStockCode()" class="form-control" name="stock_codes_update" id="stock_codes_update">
                                @foreach($stock_codes as $stock_code)
                                    <option value="{{$stock_code}}">{{$stock_code}}</option>
                                @endforeach
                            </select> 
                        </div>

                        <div id="display_update" class="form-group">
                            <label for="custom_update">CUSTOM PLAN</label>
                            <input id="custom_update" class="form-control" type="text">
                        </div>

                        <div class="form-group">
                            <label for="qty_update">QTY:</label>
                            <input type="hidden" id="plan_id">
                            <input id="qty_update" class="form-control" name="qty_update" type="number" min='0' >
                        </div>

                        <div class="form-group">
                            <button onclick="updatePlan()" class="btn btn-success btn-block" style="width:100%;" type="button">UPDATE</button>
                        </div>
                       
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <button onclick="confirmDelete()" class="btn btn-danger btn-block" type="button">DELETE PLAN</button>
                </div>
            </div>
        </div>
    </div>
</div>



