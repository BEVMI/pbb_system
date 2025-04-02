<div class="modal fade" data-bs-backdrop='static' id="modalCreate2" tabindex="-1" role="dialog" aria-labelledby="modalCreateCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold badge bg-primary" id="modalCreateLongTitle" style="font-size:16px;">PLAN CREATION</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="stock_codes_create">STOCK CODE:</label>
                    <select class="form-control" name="stock_codes_create_plan" id="stock_codes_create_plan">
                        @foreach($stock_codes as $stock_code)
                            <option value="{{$stock_code}}">{{$stock_code}}</option>
                        @endforeach
                    </select> 
                </div>
                <div class="form-group">
                    <label for="date_plan">PLAN DATE</label>
                    <input type="date" class="form-control" id="date_plan"> 
                </div>
                <div class="form-group" style="display: none;">
                    <label for="month_plan">MONTH PLAN</label>
                    <select id="month_plan" class="form-control">
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
                <div class="form-group" style="display: none;">
                    <div class="form-group">
                        <label for="year_plan">YEAR</label>
                        <input class="form-control" id='year_plan' type="number" value="{{$year_now}}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-group">
                        <label for="line_plan">LINE</label>
                        <select id="line_plan" class="form-control">
                            @foreach ($lines as $line_post )
                                @if($line == $line_post->id)
                                    <option selected value="{{$line_post->id}}">{{$line_post->cDescription}}</option>
                                @else
                                    <option value="{{$line_post->id}}">{{$line_post->cDescription}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="qty_plan">PLAN QTY</label>
                    <input type="number" min="0" class="form-control" id="qty_plan" placeholder="PLAN VALUE">
                </div>
            </div>
            <div class="modal-footer">
                <button id="upload" onclick="insertPlan()" class="btn btn-success mt-2 mt-xl-0"style="width:100%;">
                    SAVE
                </button> 
            </div>
        </div>
    </div>
</div>