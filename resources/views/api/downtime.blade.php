<script>

    const now = new Date(); 
    const currentDateTime = now.toLocaleTimeString([], {timeZone: 'Asia/Manila',hour: '2-digit', minute:'2-digit',hour12: false});
    const currentDate = now.toISOString();
    document.getElementById('FBO').value = currentDateTime;
    document.getElementById('LBO').value = currentDateTime;
    $('#myList a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    })

    $('#myList1 a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    })

    function get_machines(){
        $('#machine_body').empty();
        $('#expected_downtime_body').empty();
        $('#unexpected_downtime_body').empty();
        document.getElementById('tbody_create').style.display = "";
        document.getElementById('hidden_button').style.display = "";
        let line = document.getElementById('lines').value;
        let job_date = document.getElementById('job_date').value;
        
        let job_number = document.getElementById('job_number').value;
        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Downtime/GetDowntimeDetails?iDowntimeHeaderId=0&iLineId='+line+'&dCountDate='+job_date+'&iJobNo='+job_number,
            success: function (data) {
                irene_parse = data;

                document.getElementById('sku_create').innerHTML = irene_parse.stockCode;

                document.getElementById('sku_cases_create').innerHTML = irene_parse.cases;
                document.getElementById('total_cases_create').innerHTML = irene_parse.cases;
                document.getElementById('sku_bottle_create').innerHTML = irene_parse.cases * irene_parse.pcsCase;
                document.getElementById('total_bottles_create').innerHTML =  irene_parse.cases * irene_parse.pcsCase;
                document.getElementById('total_pallets_create').innerHTML = irene_parse.palletCount;
                document.getElementById('sku_pallet_create').innerHTML = irene_parse.palletCount;
                document.getElementById('machine_cycle_time_create').innerHTML = irene_parse.idealCycleTime;
                document.getElementById('machine_count_create').value = irene_parse.machineCount;
                document.getElementById('pcs_case_create').value = irene_parse.pcsCase;

                $.each(irene_parse.machineDowntime, function(index,item) {
                    var x = document.getElementById('machine_body').insertRow(-1);
                    var i = x.insertCell(0);
                    var r = x.insertCell(1);
                    
                    let hidden_description = '<input name="mcd_desc[]" type="hidden" value="'+item.description+'">';
                    let hidden_type_id = '<input name="mcd_type_id[]" type="hidden" value="'+item.downtimeTypeId+'">';

                    i.innerHTML = item.description+hidden_description+hidden_type_id;
                    r.innerHTML = '<input onkeyup="irene(0)" class="total-create form-control form-control-sm" name="mcd_minutes[]" type="number" min="0" value="0">';
                   
                });

                $.each(irene_parse.expectedDowntime, function(index,item) {
                    var x = document.getElementById('expected_downtime_body').insertRow(-1);
                    var i = x.insertCell(0);
                    var r = x.insertCell(1);
                    
                    let hidden_description = '<input name="exp_desc[]" type="hidden" value="'+item.description+'">';
                    let hidden_type_id = '<input name="exp_type_id[]" type="hidden" value="'+item.downtimeTypeId+'">';

                    i.innerHTML = item.description+hidden_description+hidden_type_id;
                    r.innerHTML = '<input onkeyup="irene(0)" class="total-create form-control form-control-sm" name="exp_minutes[]" type="number" min="0" value="0">';
                   
                });

                $.each(irene_parse.unexpectedDowntime, function(index,item) {
                    var x = document.getElementById('unexpected_downtime_body').insertRow(-1);
                    var i = x.insertCell(0);
                    var r = x.insertCell(1);
                    
                    let hidden_description = '<input name="unexp_desc[]" type="hidden" value="'+item.description+'">';
                    let hidden_type_id = '<input name="unexp_type_id[]" type="hidden" value="'+item.downtimeTypeId+'">';

                    i.innerHTML = item.description+hidden_description+hidden_type_id;
                    r.innerHTML = '<input onkeyup="irene(0)" class="total-create form-control form-control-sm" name="unexp_minutes[]" type="number" min="0" value="0">';
                   
                });
            }
        });
    }

    function irene(flag){ 
        if(flag===0){
            let line = document.getElementById('lines').value;
            let job_date = document.getElementById('job_date').value;
            let job_number = document.getElementById('job_number').value;
            variable = 'create';
            variable2 = 'irene2';

            mcd_minutes = document.getElementsByName('mcd_minutes[]');
            unexp_minutes = document.getElementsByName('unexp_minutes[]');
            exp_minutes = document.getElementsByName('exp_minutes[]');
            
        }else{
            variable = 'update';
            variable2 = 'irene3';

            mcd_minutes = document.getElementsByName('mcd_minutes_update[]');
            unexp_minutes = document.getElementsByName('unexp_minutes_update[]');
            exp_minutes = document.getElementsByName('exp_minutes_update[]');
        }
        
        mctotal = [];
        extotal = [];
        uextotal = [];
        totalSum = [];
        for (var i = 0; i < mcd_minutes.length; i++) {
            if(mcd_minutes[i].value == ''){
                mcd_minutes_post = 0;
            }else{
                mcd_minutes_post = parseInt(mcd_minutes[i].value);
            }
            mctotal.push(mcd_minutes_post);
            totalSum.push(mcd_minutes_post);
        }
        for (var i = 0; i < exp_minutes.length; i++) {
            if(exp_minutes[i].value == ''){
                exp_minutes_post = 0;
            }else{
                exp_minutes_post = parseInt(exp_minutes[i].value);
            }
            extotal.push(exp_minutes_post);
            totalSum.push(exp_minutes_post);
        }
        for (var i = 0; i < unexp_minutes.length; i++) {
            if(unexp_minutes[i].value == ''){
                unexp_minutes_post = 0;
            }else{
                unexp_minutes_post = parseInt(unexp_minutes[i].value);
            }
            uextotal.push(unexp_minutes_post);
            totalSum.push(unexp_minutes_post);
        }
        total = sum(totalSum);
        mctotal_post = sum(mctotal);
        extotal_post = sum(extotal);
        uextotal_post = sum(uextotal);
        
        document.getElementById(variable2).innerHTML = total; 
        document.getElementById('mctotal').innerHTML = mctotal_post;
        document.getElementById('extotal').innerHTML = extotal_post;
        document.getElementById('uextotal').innerHTML = uextotal_post;
       
        let cases = document.getElementById('total_cases_'+variable).innerHTML;
        let bottles = document.getElementById('total_bottles_'+variable).innerHTML;
        let pallet_count = document.getElementById('sku_pallet_'+variable).innerHTML;
        let cycle_time = document.getElementById('machine_cycle_time_'+variable).innerHTML;
        let shift_length_create = document.getElementById('shift_length_'+variable).value;
        // SHIFT LENGTH TO RUNNING TIME
        // Shift Length
        document.getElementById('shift_length_'+variable+'2').innerHTML = shift_length_create;
        // Expected Oprl Downtime Mins
        document.getElementById('expected_oprl_'+variable).innerHTML = extotal_post;
        // UnExpected Oprl Downtime Mins
        document.getElementById('unexpected_oprl_'+variable).innerHTML = uextotal_post;

        // Planned Production Time, mins = Shift Length - Expected Downtime;
        planned_production_time = shift_length_create-extotal_post;
        document.getElementById('planned_oprl_'+variable).innerHTML = planned_production_time;

        // Operating Time, mins = Planned Production Time - Unexpected Downtime;
        operating_time_create = planned_production_time - uextotal_post;
        document.getElementById('operating_time_'+variable).innerHTML = operating_time_create;

        // Machine Downtime
        document.getElementById('machine_declared_'+variable).innerHTML = mctotal_post;

        // % Machine Downtime = (Machine Declated Downtime / Operating time, mins) * 100
        machine_downtime = (mctotal_post/operating_time_create)*100;
        document.getElementById('machine_downtime_'+variable).innerHTML = machine_downtime.toFixed(0)+'%';

        // Running Time, mins = FG Bottles / Ideal Cycle Time, btls/min
        running_time = bottles / cycle_time;
        if (isNaN(running_time)) {
            document.getElementById('running_time_'+variable).innerHTML = 0;
        }else{  
            document.getElementById('running_time_'+variable).innerHTML = running_time.toFixed(0);
        }
       
        // Total FG, Bottles ,Cases and Pallets
        // cases,bottles and cases function is below function 
        // Cycle Time under below function 
        
        // Expected Output, Bottles = Operating Time, mins * Ideal Cycle Time, Btls/min
        expected_output = planned_production_time * cycle_time;
        document.getElementById('expected_output_'+variable).innerHTML = expected_output;

        // Machine Actual Downtime, mins = (Expected Output - Total FG Bottles) / Cycle Time  
        machine_actual = (expected_output - bottles) / cycle_time;
        if (isNaN(machine_actual)) {
            document.getElementById('machine_actual_downtime_'+variable).innerHTML = 0;
        }else{
            document.getElementById('machine_actual_downtime_'+variable).innerHTML = machine_actual.toFixed(0);
        }
      
        // Variance = Machine Declated Downtime, mins - Machine Actual Downtime, mins
        downtime_variance = mctotal_post - machine_actual;
        if (isNaN(downtime_variance)) {
            document.getElementById('downtime_variance_'+variable).innerHTML = 0;
        }else{
            document.getElementById('downtime_variance_'+variable).innerHTML = downtime_variance.toFixed(0);
        }
        
        // Machine Count 
        machineCount = document.getElementById('machine_count_'+variable).value;
        pcs_case = document.getElementById('pcs_case_'+variable).value;
        
        // Machine Counter rdg, bottles = Machine Count * pcsCase
        rdg_machine = machineCount * pcs_case;       
        document.getElementById('machine_bottles_'+variable).innerHTML = rdg_machine;

        // Availability = Operating Time, mins /  Planned Production Time, mins
        if (isNaN(downtime_variance)) {
            availability = 0;
        }else{
            availability = (operating_time_create/planned_production_time)*100;
        }  
        document.getElementById('availability_'+variable).innerHTML = availability.toFixed(2);
        
        // Performance(%) = Running Time,mins / Operating Time, mins
        performance = (running_time.toFixed(0)/operating_time_create) * 100;
        if (isNaN(performance)) {
            document.getElementById('performance_'+variable).innerHTML = 0;
        }else{
            document.getElementById('performance_'+variable).innerHTML = performance.toFixed(2)+'%';
        }
        
        // Quality = Total FG, Bottles / Machine Counter rdg, Bottles
        quality = (bottles/rdg_machine) * 100;
        if (isNaN(quality)) {
            document.getElementById('quality_'+variable).innerHTML = 0;
        }else{
            document.getElementById('quality_'+variable).innerHTML = quality.toFixed(2)+'%';
        }

        // OEEE = ((Performance(%)/100) * (Quality(%)/100) * (Availability(%)/100)) * 100  
        oeee = ((performance.toFixed(2)/100) * (quality.toFixed(2)/100) * (availability.toFixed(2)/100)*100);
        if (isNaN(oeee)) {
            document.getElementById('oee_'+variable).innerHTML =0;
        }{
            document.getElementById('oee_'+variable).innerHTML = oeee.toFixed(2);
        }
        
    }

    function sum(total){
        const sum = total.reduce((partialSum, a) => partialSum + a, 0);
        return sum;
    }

    function irene_update(){ 
        let mcd_minutes = document.getElementsByName('mcd_minutes_update[]');
        let unexp_minutes = document.getElementsByName('unexp_minutes_update[]');
        let exp_minutes = document.getElementsByName('exp_minutes_update[]');
        let mctotal = [];
        let extotal = [];
        let uextotal = [];
        let totalSum = [];
        for (var i = 0; i < mcd_minutes.length; i++) {
            if(mcd_minutes[i].value == ''){
                mcd_minutes_post = 0;
            }else{
                mcd_minutes_post = parseInt(mcd_minutes[i].value);
            }
            mctotal.push(mcd_minutes_post);
            totalSum.push(mcd_minutes_post);
        }
        for (var i = 0; i < exp_minutes.length; i++) {
            if(exp_minutes[i].value == ''){
                exp_minutes_post = 0;
            }else{
                exp_minutes_post = parseInt(exp_minutes[i].value);
            }
            extotal.push(exp_minutes_post);
            totalSum.push(exp_minutes_post);
        }
        for (var i = 0; i < unexp_minutes.length; i++) {
            if(unexp_minutes[i].value == ''){
                unexp_minutes_post = 0;
            }else{
                unexp_minutes_post = parseInt(unexp_minutes[i].value);
            }
            uextotal.push(unexp_minutes_post);
            totalSum.push(unexp_minutes_post);
        }
        let total = sum(totalSum);
        document.getElementById('irene3').innerHTML = total; 
        document.getElementById('mctotal_update').innerHTML = mctotal_post;
        document.getElementById('extotal_update').innerHTML = extotal_post;
        document.getElementById('uextotal_update').innerHTML = uextotal_post;
    }

    function updateDowntime(id,line,job,date,shift_length_post,dFBO,dLBO){
        $('#modalEdit').modal('show');
        document.getElementById('update_id').value = id;
        document.getElementById('lines_update').value = line;
        document.getElementById('job_number_update').value = job;
        document.getElementById('downtime_date_update').value = formatDate(date);
        
        var d = new Date(dFBO),
            h = (d.getHours()<10?'0':'') + d.getHours(),
            m = (d.getMinutes()<10?'0':'') + d.getMinutes();
        
        var d2 = new Date(dLBO),
            h2 = (d2.getHours()<10?'0':'') + d2.getHours(),
            m2 = (d2.getMinutes()<10?'0':'') + d2.getMinutes();
   
    
        document.getElementById('FBO_update').value = dFBO.value = h + ':' + m;
        document.getElementById('LBO_update').value =  dLBO.value = h2 + ':' + m2;
        
        let job_date = formatDate(date);
        let shift_length = shift_length_post;
        document.getElementById('shift_length_update').value = shift_length;
        
        $('#machine_body_update').empty();
        $('#expected_downtime_body_update').empty();
        $('#unexpected_downtime_body_update').empty();
        mcd_total_get = [];
        exp_total_get = [];
        uexp_total_get = [];
        total_update_get = [];
        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Downtime/GetDowntimeDetails?iDowntimeHeaderId='+id+'&iLineId='+line+'&dCountDate='+job_date+'&iJobNo='+job,
            
            success: function (data) {
                irene_parse = data;
                document.getElementById('sku_update').innerHTML = irene_parse.stockCode;

                document.getElementById('sku_cases_update').innerHTML = irene_parse.cases;
                document.getElementById('total_cases_update').innerHTML = irene_parse.cases;
                document.getElementById('sku_bottle_update').innerHTML = irene_parse.cases * irene_parse.pcsCase;
                document.getElementById('total_bottles_update').innerHTML =  irene_parse.cases * irene_parse.pcsCase;
                document.getElementById('total_pallets_update').innerHTML = irene_parse.palletCount;
                document.getElementById('sku_pallet_update').innerHTML = irene_parse.palletCount;
                document.getElementById('machine_cycle_time_update').innerHTML = irene_parse.idealCycleTime;
                document.getElementById('machine_count_update').value = irene_parse.machineCount;
                document.getElementById('pcs_case_update').value = irene_parse.pcsCase;
                
                $.each(irene_parse.machineDowntime, function(index,item) {
                    var x = document.getElementById('machine_body_update').insertRow(-1);
                    var i = x.insertCell(0);
                    var r = x.insertCell(1);
                    
                    let hidden_description = '<input name="mcd_desc_update[]" type="hidden" value="'+item.description+'">';
                    let hidden_type_id = '<input name="mcd_type_id_update[]" type="hidden" value="'+item.downtimeTypeId+'">';

                    i.innerHTML = item.description+hidden_description+hidden_type_id;
                    r.innerHTML = '<input onkeyup="irene(1)" class="form-control" name="mcd_minutes_update[]" type="number" min="0" value="'+item.iMinute+'">';
                    mcd_total_get.push(item.iMinute);
                    total_update_get.push(item.iMinute);
                });

                $.each(irene_parse.expectedDowntime, function(index,item) {
                    var x = document.getElementById('expected_downtime_body_update').insertRow(-1);
                    var i = x.insertCell(0);
                    var r = x.insertCell(1);
                    
                    let hidden_description = '<input name="exp_desc_update[]" type="hidden" value="'+item.description+'">';
                    let hidden_type_id = '<input name="exp_type_id_update[]" type="hidden" value="'+item.downtimeTypeId+'">';

                    i.innerHTML = item.description+hidden_description+hidden_type_id;
                    r.innerHTML = '<input onkeyup="irene(1)"  class="form-control" name="exp_minutes_update[]" type="number" min="0" value="'+item.iMinute+'">';
                    exp_total_get.push(item.iMinute);
                    total_update_get.push(item.iMinute);
                });

                $.each(irene_parse.unexpectedDowntime, function(index,item) {
                    var x = document.getElementById('unexpected_downtime_body_update').insertRow(-1);
                    var i = x.insertCell(0);
                    var r = x.insertCell(1);
                    
                    let hidden_description = '<input name="unexp_desc_update[]" type="hidden" value="'+item.description+'">';
                    let hidden_type_id = '<input name="unexp_type_id_update[]" type="hidden" value="'+item.downtimeTypeId+'">';

                    i.innerHTML = item.description+hidden_description+hidden_type_id;
                    r.innerHTML = '<input onkeyup="irene(1)" class="form-control" name="unexp_minutes_update[]" type="number" min="0" value="'+item.iMinute+'">';
                    uexp_total_get.push(item.iMinute);
                    total_update_get.push(item.iMinute);
                });

                let total = sum(total_update_get);
                let mc_total_post = sum(mcd_total_get);
                let exp_total_post = sum(exp_total_get);
                let uexp_total_post = sum(uexp_total_get);
                document.getElementById('irene3').innerHTML = total;
                document.getElementById('mctotal_update').innerHTML = mc_total_post;
                document.getElementById('extotal_update').innerHTML = exp_total_post;
                document.getElementById('uextotal_update').innerHTML = uexp_total_post; 
                irene(1);
            }
        });

    }

    function hideall(){
        $('#machine_body').empty();
        $('#expected_downtime_body').empty();
        $('#unexpected_downtime_body').empty();
        document.getElementById('mctotal').innerHTML = 0;
        document.getElementById('extotal').innerHTML = 0;
        document.getElementById('uextotal').innerHTML = 0;
        
        document.getElementById('tbody_create').style.display = "none";
        document.getElementById('hidden_button').style.display = "none";
    }

    function update(){
        //MAIN
        let id = document.getElementById('update_id').value;
        let job = document.getElementById('job_number_update').value;
        let lines = document.getElementById('lines_update').value;
        let created_by = "{!!$user_auth->name!!}";
        let shift_length_create = document.getElementById('shift_length_update').value;
        let downtime_date_update = document.getElementById('downtime_date_update').value;
        //MACHINE BODY
        let mcd_desc = document.getElementsByName('mcd_desc_update[]');
        let mcd_type_id = document.getElementsByName('mcd_type_id_update[]');
        let mcd_minutes = document.getElementsByName('mcd_minutes_update[]');
        
       
        const date_now = new Date(); 

        const currentYear = date_now.getFullYear('en-US', { timeZone: 'Asia/Manila' });
        const currentMonth = date_now.getMonth('en-US', { timeZone: 'Asia/Manila' })+1;
        const getDate = date_now.getDate('en-US', { timeZone: 'Asia/Manila' });

        if(currentMonth == '11' || currentMonth == '12' || currentMonth == '10'){
            zero = '';
        }else{
            zero = '0';
        }
        if(getDate == '1' || getDate == '2' || getDate == '3' || getDate == '4' || getDate == '5' || getDate == '6' || getDate == '7' || getDate == '8' || getDate == '9'){
            zeroday = '0';
        }else{
            zeroday = '';
        }
      
        let fbo_update = currentYear+'-'+zero+currentMonth+'-'+zeroday+getDate+'T'+document.getElementById('FBO_update').value;
        let lbo_update = currentYear+'-'+zero+currentMonth+'-'+zeroday+getDate+'T'+document.getElementById('LBO_update').value;
        // console.log(fbo_update);
        
        let mcdDetails_update = [];
        for (var i = 0; i < mcd_desc.length; i++) {
            let mcd_type_id_post = mcd_type_id[i].value;
            let mcd_minutes_post = mcd_minutes[i].value;
            
            mcdDetails_update.push({
                "iMinute": mcd_minutes_post,
                "downtimeTypeId": mcd_type_id_post
            });
        }
        //END MACHINE BODY
        
        //EXPECTED BODY
        let exp_desc = document.getElementsByName('exp_desc_update[]');
        let exp_type_id = document.getElementsByName('exp_type_id_update[]');
        let exp_minutes = document.getElementsByName('exp_minutes_update[]');
        
        let expDetails_update = [];
        for (var i = 0; i < exp_desc.length; i++) {
            let exp_type_id_post = exp_type_id[i].value;
            let exp_minutes_post = exp_minutes[i].value;
            
            expDetails_update.push({
                "iMinute": exp_minutes_post,
                "downtimeTypeId": exp_type_id_post
            });
        }
        //END EXPECTED BODY

        //UNEXPECTED BODY
        let unexp_desc = document.getElementsByName('unexp_desc_update[]');
        let unexp_type_id = document.getElementsByName('unexp_type_id_update[]');
        let unexp_minutes = document.getElementsByName('unexp_minutes_update[]');
        let unexpDetails_update = [];
        for (var i = 0; i < unexp_desc.length; i++) {
            let unexp_type_id_post = unexp_type_id[i].value;
            let unexp_minutes_post = unexp_minutes[i].value;
            
            unexpDetails_update.push({
                "iMinute": unexp_minutes_post,
                "downtimeTypeId": unexp_type_id_post
            });
        }
        //END UNEXPECTED BODY
       
        $.ajax({
            type:'POST',
            method:'POST',
            url:api_url+'/Downtime/UpdateDowntimeHeader',
            crossDomain: true,
            dataType: 'json',
            headers: { 
                'Accept': 'application/json',
                'Content-Type': 'application/json' 
            },
            data:  JSON.stringify({
                "id": id,
                "lineId": lines,
                "jobNo": job,
                "shiftLength": shift_length_create,
                "createdBy":created_by,
                "downtimeDate":downtime_date_update,
                "machineDowntime":mcdDetails_update,
                "expectedDowntime":expDetails_update,
                "unexpectedDowntime":unexpDetails_update,
                "fbo":fbo_update,
                "lbo":lbo_update
            }),
            success:function(data){
                expDetails_update = [];
                unexpDetails_update = [];
                mcdDetails_update = [];
                
                $('#machine_body_update').empty();
                $('#expected_downtime_body_update').empty();
                $('#unexpected_downtime_body_update').empty();
                document.getElementById('hidden_button').style.display = "none";
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "SUCCESSFULLY SAVED",
                    showConfirmButton: false,
                    timer: 2000
                });
                setTimeout(() => {
                   load();
                    $('#modalEdit').modal('hide');
                }, "2000");
            }
        });
    }

    function create(){
        //MAIN
        let job = document.getElementById('job_number').value;
        let lines = document.getElementById('lines').value;
        let created_by = "{!!$user_auth->name!!}";
        let date = document.getElementById('job_date').value;

        const date_now = new Date(); 

        const currentYear = date_now.getFullYear('en-US', { timeZone: 'Asia/Manila' });
        const currentMonth = date_now.getMonth('en-US', { timeZone: 'Asia/Manila' })+1;
        const getDate = date_now.getDate('en-US', { timeZone: 'Asia/Manila' });
        
        if(currentMonth == '11' || currentMonth == '12' || currentMonth == '10'){
            zero = '';
        }else{
            zero = '0';
        }

        if(getDate == '1' || getDate == '2' || getDate == '3' || getDate == '4' || getDate == '5' || getDate == '6' || getDate == '7' || getDate == '8' || getDate == '9'){
            zeroday = '0';
        }else{
            zeroday = '';
        }
        let fbo = currentYear+'-'+zero+currentMonth+'-'+zeroday+getDate+'T'+document.getElementById('FBO').value;
        let lbo = currentYear+'-'+zero+currentMonth+'-'+zeroday+getDate+'T'+document.getElementById('LBO').value;
        
        let shift_length_create = document.getElementById('shift_length_create').value;
        //MACHINE BODY
        let mcd_desc = document.getElementsByName('mcd_desc[]');
        let mcd_type_id = document.getElementsByName('mcd_type_id[]');
        let mcd_minutes = document.getElementsByName('mcd_minutes[]');
        let mcdDetails = [];
        for (var i = 0; i < mcd_desc.length; i++) {
            let mcd_type_id_post = mcd_type_id[i].value;
            let mcd_minutes_post = mcd_minutes[i].value;
            
            mcdDetails.push({
                "iMinute": mcd_minutes_post,
                "downtimeTypeId": mcd_type_id_post
            });
        }
        //END MACHINE BODY
        
        //EXPECTED BODY
        let exp_desc = document.getElementsByName('exp_desc[]');
        let exp_type_id = document.getElementsByName('exp_type_id[]');
        let exp_minutes = document.getElementsByName('exp_minutes[]');

        let expDetails = [];
        for (var i = 0; i < exp_desc.length; i++) {
            let exp_type_id_post = exp_type_id[i].value;
            let exp_minutes_post = exp_minutes[i].value;
            
            expDetails.push({
                "iMinute": exp_minutes_post,
                "downtimeTypeId": exp_type_id_post
            });
        }
        //END EXPECTED BODY

        //UNEXPECTED BODY
        let unexp_desc = document.getElementsByName('unexp_desc[]');
        let unexp_type_id = document.getElementsByName('unexp_type_id[]');
        let unexp_minutes = document.getElementsByName('unexp_minutes[]');
        let unexpDetails = [];
        for (var i = 0; i < unexp_desc.length; i++) {
            let unexp_type_id_post = unexp_type_id[i].value;
            let unexp_minutes_post = unexp_minutes[i].value;
            
            unexpDetails.push({
                "iMinute": unexp_minutes_post,
                "downtimeTypeId": unexp_type_id_post
            });
        }
        //END UNEXPECTED BODY
        document.getElementById("hidden_button").disabled = true;
        $.ajax({
            type:'POST',
            method:'POST',
            url:api_url+'/Downtime/UpdateDowntimeHeader',
            crossDomain: true,
            dataType: 'json',
            headers: { 
                'Accept': 'application/json',
                'Content-Type': 'application/json' 
            },
            data:  JSON.stringify({
                "id": 0,
                "lineId": lines,
                "jobNo": job,
                "shiftLength": shift_length_create,
                "createdBy":created_by,
                "downtimeDate":date,
                "machineDowntime":mcdDetails,
                "expectedDowntime":expDetails,
                "unexpectedDowntime":unexpDetails,
                "fbo":fbo,
                "lbo":lbo,
            }),
            success:function(data){
                expDetails = [];
                unexpDetails = [];
                mcdDetails = [];
                
                $('#machine_body').empty();
                $('#expected_downtime_body').empty();
                $('#unexpected_downtime_body').empty();
                document.getElementById('tbody_create').style.display = "none";
                document.getElementById('hidden_button').style.display = "none";
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "SUCCESSFULLY SAVED",
                    showConfirmButton: false,
                    timer: 2000
                });
                setTimeout(() => {
                   load();
                   document.getElementById("hidden_button").disabled = false;
                    $('#modalCreate').modal('hide');
                }, "2000");
            }
        });
    }
</script>