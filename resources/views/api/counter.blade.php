<script>
    const now = new Date(); 
    const currentDateTime = now.toLocaleTimeString([], {timeZone: 'Asia/Manila',hour: '2-digit', minute:'2-digit',hour12: false});
    const currentDate = now.toISOString();
    document.getElementById('FBO').value = currentDateTime;
    document.getElementById('LBO').value = currentDateTime;
    $('#job_number_update').css('pointer-events','none');
    $(document).ready(function(){
        let line_start = document.getElementById('line_search').value;
        let month_now_start = document.getElementById('month_now').value;
        let year_now = document.getElementById('year_now').value;
        getCounter(line_start,year_now,month_now_start);
            Swal.fire({
            position: "center",
            icon: "success",
            title: "LOADING PLEASE WAIT",
            showConfirmButton: false,
            timer: 2500
        });
    });

    function reset(){
        $('#counter_body').empty();
        document.getElementById('post_counter').style.display = 'none';
    }

    function search(){
        let line_start = document.getElementById('line_search').value;
        let month_now_start = document.getElementById('month_now').value;
        let year_now = document.getElementById('year_now').value;
        getCounter(line_start,year_now,month_now_start);
            Swal.fire({
            position: "center",
            icon: "success",
            title: "LOADING PLEASE WAIT",
            showConfirmButton: false,
            timer: 2500
        });
    }
    function getCounter(line,year,month){
        $('#machine_body_table').empty();
        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/MachineCounter/GetMachineCounterHeaders?iMachineCountHeaderId=0&iLineId='+line+'&nYear='+year+'&nMonth='+month,
            success: function (data) {
                irene_parse = JSON.parse(data);
                // console.log(irene_parse);
                $.each(irene_parse, function(index,item) {
                    var x = document.getElementById('machine_body_table').insertRow(-1);
                    var i = x.insertCell(0);
                    var r = x.insertCell(1);
                    var e = x.insertCell(2);
                    var n = x.insertCell(3);
                    var j = x.insertCell(4);
               

                    i.innerHTML = item.iLineId;
                    r.innerHTML = item.iJobNo;  
                    e.innerHTML = formatDate(item.dDate);
                    n.innerHTML = item.cEncodedBy;    
                    j.innerHTML = '<a href="#" class="btn btn-success mt-2 mt-xl-0 view_data" data-bs-toggle="modal" data-bs-target="#modalView" data-id="'+item.id+'" data-line="'+item.iLineId+'"> <i class="fas fa-eye"></i></a>';      
                      
              
                });
            }
        });
    }
</script>
</script>
<script></script>

<script>
    function getSections(line){
        $('#counter_body').empty();
        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/MachineCounter/GetMachineCounterDetails?iMachineCounterHeaderId=0&iLineNo='+line,
            success: function (data) {
                irene_parse = data;
                let count = irene_parse.counterDetails.length;
                if(count > 0){
                    document.getElementById('post_counter').style.display = 'block'; 
                }else{
                    document.getElementById('post_counter').style.display = 'none'; 
                }
                $.each(irene_parse.counterDetails, function(index,item) {
                    var x = document.getElementById('counter_body').insertRow(-1);
                    var i = x.insertCell(0);
                    var r = x.insertCell(1);
                    var e = x.insertCell(2);
                    

                    i.innerHTML = item.section+'<input type="hidden" name="section_id[]" value='+item.sectionId+'><input type="hidden" name="sections_create[]" value="'+item.section+'">';
                    if(item.useInOut ==1){
                        r.innerHTML = '<input class="form-control " name="in_create[]" type="number" min="0"  value="0">';
                    }else{
                        r.innerHTML = '<input name="in_create[]" type="hidden" min="0" value="0">';
                    }
                   
                    e.innerHTML = '<input type="hidden" name="flag[]" value='+item.useInOut+'><input class="form-control" name="out_create[]" type="number" min="0"  value="0">';  
                });
            }
        });
    }
</script>

<script>
    function hideFields(){
        $('#counter_body').empty();
        document.getElementById('post_counter').style.display = 'none'; 
    }

    function choose_line(){
        $(document).ready(function(){
            let line = document.getElementById('lines').value;
            let job_number = document.getElementById('job_number').value;
            let date_counter = document.getElementById('date_counter').value;
            $('#machine_body').empty();
            $('#expected_downtime_body').empty();
            $('#unexpected_downtime_body').empty();
            let myArray = job_number.split("_");
            if(!job_number || !date_counter){
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "PLEASE FILL UP THE JOB OR DATE FIELD",
                    showConfirmButton: false,
                    timer: 2500
                });
            }else{
                $.ajax({
                    type: 'GET', //THIS NEEDS TO BE GET
                    url: api_url+'/Downtime/GetDowntimeDetails?iDowntimeHeaderId=0&iLineId='+line+'&dCountDate='+date_counter+'&iJobNo='+myArray[0],
                    success: function (data) {
                        irene_parse = data;

                        $.each(irene_parse.machineDowntime, function(index,item) {
                            var x = document.getElementById('machine_body').insertRow(-1);
                            var i = x.insertCell(0);
                            var r = x.insertCell(1);
                            
                            let hidden_description = '<input name="mcd_desc[]" type="hidden" value="'+item.description+'">';
                            let hidden_type_id = '<input name="mcd_type_id[]" type="hidden" value="'+item.downtimeTypeId+'">';

                            i.innerHTML = item.description+hidden_description+hidden_type_id;
                            r.innerHTML = '<input onkeyup="irene(0)" class="total-create form-control" name="mcd_minutes[]" type="number" min="0" value="0">';
                        
                        });

                        $.each(irene_parse.expectedDowntime, function(index,item) {
                            var x = document.getElementById('expected_downtime_body').insertRow(-1);
                            var i = x.insertCell(0);
                            var r = x.insertCell(1);
                            
                            let hidden_description = '<input name="exp_desc[]" type="hidden" value="'+item.description+'">';
                            let hidden_type_id = '<input name="exp_type_id[]" type="hidden" value="'+item.downtimeTypeId+'">';

                            i.innerHTML = item.description+hidden_description+hidden_type_id;
                            r.innerHTML = '<input onkeyup="irene(0)" class="total-create form-control" name="exp_minutes[]" type="number" min="0" value="0">';
                        
                        });

                        $.each(irene_parse.unexpectedDowntime, function(index,item) {
                            var x = document.getElementById('unexpected_downtime_body').insertRow(-1);
                            var i = x.insertCell(0);
                            var r = x.insertCell(1);
                            
                            let hidden_description = '<input name="unexp_desc[]" type="hidden" value="'+item.description+'">';
                            let hidden_type_id = '<input name="unexp_type_id[]" type="hidden" value="'+item.downtimeTypeId+'">';

                            i.innerHTML = item.description+hidden_description+hidden_type_id;
                            r.innerHTML = '<input onkeyup="irene(0)" class="total-create form-control" name="unexp_minutes[]" type="number" min="0" value="0">';
                        
                        });
                    }
                });

                get_rejects(0,line).done(function(irene_parse){
                let details = irene_parse.rejectDetails;
               
                $('#reject_body').empty();
                    $.each(details, function(index,item) {
                        var x = document.getElementById('reject_body').insertRow(-1);
                        var i = x.insertCell(0);
                        var r = x.insertCell(1);
                        var e = x.insertCell(2);

                        i.innerHTML = item.section+'<input name="materialId[]" value="'+item.materialId+'" type="hidden">';
                        r.innerHTML = item.materials+'<input name="sectionId[]" value="'+item.sectionId+'" type="hidden">';  
                        e.innerHTML = '<input name="section[]" value="'+item.section+'" type="hidden"><input name="materials[]" value="'+item.materials+'" type="hidden"><input type="number" value="0" name="qty[]" class="form-control">';
                
                    });
                });

                getSections(line);
                    Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "LOADING PLEASE WAIT",
                    showConfirmButton: false,
                    timer: 2500
                });
                
            }
           
        });
    }

    function postCounter(){
        let line = document.getElementById('lines').value;
        let line_name = $("#lines option:selected").text();
        
        let value = document.getElementById('job_number').value;
        let iLossPallet = document.getElementById('iLossPallet').value;

        let split = value.split("_");
        let job = split[0];
        let id_now = split[1];
        let sections_post = document.getElementsByName('sections_create[]');
        let section_id_post = document.getElementsByName('section_id[]');
        let ins_post = document.getElementsByName('in_create[]');
        let outs_post = document.getElementsByName('out_create[]');
        let flag_post = document.getElementsByName('flag[]');
        let counterDetails = [];
        let initial_date = document.getElementById('date_counter').value;
        let cEncodedBy = "{!!$user_auth->name!!}";

        let line_start = document.getElementById('line_search').value;
        let month_now_start = document.getElementById('month_now').value;
        let year_now = document.getElementById('year_now').value;
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

        let fbo_update = currentYear+'-'+zero+currentMonth+'-'+zeroday+getDate+'T'+document.getElementById('FBO').value;
        let lbo_update = currentYear+'-'+zero+currentMonth+'-'+zeroday+getDate+'T'+document.getElementById('LBO').value;
       
        document.getElementById("post_counter").disabled = true;
        for (var i = 0; i < section_id_post.length; i++) {
            let section_id=section_id_post[i].value;
            let ins=ins_post[i].value;
            let outs=outs_post[i].value;
            let sections = sections_post[i].value;
            let flag = flag_post[i].value;
            counterDetails.push({
                "sectionId": section_id,
                "section": sections,
                "start": ins,
                "end": outs,
                "useInOut": flag
            });
        }
        
        $.ajax({
            type:'POST',
            method:'POST',
            url:api_url+'/MachineCounter/UpdateMachineCounterHeader',
            crossDomain: true,
            dataType: 'json',
            headers: { 
                'Accept': 'application/json',
                'Content-Type': 'application/json' 
            },
            data:  JSON.stringify({
                "lineId": line,
                "MachineCounterHeaderId": 0,
                "jobNo": job,
                "iLossPallet":iLossPallet,
                "iJobId":id_now,
                "cEncodedBy":cEncodedBy,
                "counterDetails":counterDetails,
                "countDate":initial_date,
                "fbo":fbo_update,
                "lbo":lbo_update,
            }),
            success:function(data){
                counterDetails = [];
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "SUCCESSFULLY SAVED",
                    showConfirmButton: false,
                    timer: 5000
                });
                
                let check_pallet = outs_post[5].value;
               
               
                setTimeout(() => {
                    getCounter(line_start,year_now,month_now_start);
                    $.ajax({
                        type: 'GET', //THIS NEEDS TO BE GET
                        url: api_url+'/MachineCounter/GetLastHeader',
                        success: function (data2) { 
                            irene_parse_3 = JSON.parse(data2);
                            create_downtime(irene_parse_3[0].id);
                            postReject(irene_parse_3[0].id);
                        }
                    });
                    document.getElementById("post_counter").disabled = false;
                    $('#modalCreate').modal('hide');
                }, "5000");
            }
        });
        
    }
    
</script>

<script>
    $(document).ready(function(){
        $(document).on('click', '.view_data', function (e) {
            let id = $(this).data('id');
            let line = $(this).data('line');
            
            document.getElementById('hidden_header_id').value = id;
            load_detail(id,line);
            load_downtime(id);
            load_rejects(id);
        });            
    });
    
    
    function load_downtime(machineId){
         $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Downtime/GetDowntimeDetailsByMachineId?iMachineCounterId='+machineId,
            success: function (data) {
                // console.log(data);
                $('#machine_body_update').empty();
                $('#expected_downtime_body_update').empty();
                $('#unexpected_downtime_body_update').empty();
                mcd_total_get = [];
                exp_total_get = [];
                uexp_total_get = [];
                total_update_get = [];
                if(data.id ===null){
                    document.getElementById('shiftLength_update').value = 0;
                    document.getElementById('dFgCases_update').value = 0;
                }else{
                    document.getElementById('shiftLength_update').value = data.shiftLength;
                    document.getElementById('dFgCases_update').value = data.dFgCases;
                    irene_parse = data;
                    $.each(irene_parse.machineDowntime, function(index,item) {
                        var x = document.getElementById('machine_body_update').insertRow(-1);
                        var i = x.insertCell(0);
                        var r = x.insertCell(1);
                        
                        let hidden_description = '<input name="mcd_desc_update[]" type="hidden" value="'+item.description+'">';
                        let hidden_type_id = '<input name="mcd_type_id_update[]" type="hidden" value="'+item.downtimeTypeId+'">';

                        i.innerHTML = item.description+hidden_description+hidden_type_id;
                        r.innerHTML = '<input class="form-control" name="mcd_minutes_update[]" type="number" min="0" value="'+item.iMinute+'">';
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
                        r.innerHTML = '<input class="form-control" name="exp_minutes_update[]" type="number" min="0" value="'+item.iMinute+'">';
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
                        r.innerHTML = '<input class="form-control" name="unexp_minutes_update[]" type="number" min="0" value="'+item.iMinute+'">';
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
                    }
                }
        });
    }
    function load_rejects(machineId){
        $('#reject_body_update').empty();
        get_reject(machineId).done(function(irene_parse){
            document.getElementById('iLossPalletReject_update').value = irene_parse[0].iLossCase;
            get_rejects(irene_parse[0].id,irene_parse[0].iLineId).done(function(irene_parse_2){
                let details = irene_parse_2.rejectDetails;
                // console.log(details);
                $.each(details, function(index,item) {
                    var x = document.getElementById('reject_body_update').insertRow(-1);
                    var i = x.insertCell(0);
                    var r = x.insertCell(1);
                    var e = x.insertCell(2);

                    i.innerHTML = item.section+'<input name="materialIdUpdate[]" value="'+item.materialId+'" type="hidden">';
                    r.innerHTML = item.materials+'<input name="sectionIdUpdate[]" value="'+item.sectionId+'" type="hidden">';  
                    e.innerHTML = '<input name="sectionUpdate[]" value="'+item.section+'" type="hidden"><input name="materialsUpdate[]" value="'+item.materials+'" type="hidden"><input type="number" value="'+item.qty+'" name="qtyUpdate[]" class="form-control">';
                    
                });
            });
        });
    }
    function load_detail(id,line){
        $('#counter_body_update').empty();
        document.getElementById('lines_update').value = line;
        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/MachineCounter/GetMachineCounterDetails?iMachineCounterHeaderId='+id+'&iLineNo='+line,
            success: function (data) {
                irene_parse = data;
                dFBO = irene_parse.fbo;
                dLBO = irene_parse.lbo;

                var d = new Date(dFBO),
                    h = (d.getHours()<10?'0':'') + d.getHours(),
                    m = (d.getMinutes()<10?'0':'') + d.getMinutes();
                
                var d2 = new Date(dLBO),
                    h2 = (d2.getHours()<10?'0':'') + d2.getHours(),
                    m2 = (d2.getMinutes()<10?'0':'') + d2.getMinutes();
        
            
                document.getElementById('FBO_update').value = dFBO.value = h + ':' + m;
                document.getElementById('LBO_update').value =  dLBO.value = h2 + ':' + m2;

                document.getElementById('job_number_update').value = irene_parse.jobNo+'_'+irene_parse.iJobId;
                document.getElementById('date_update').value = formatDate(irene_parse.countDate); 
                document.getElementById('iLossPalletUpdate').value = irene_parse.iLossPallet;
                $.each(irene_parse.counterDetails, function(index,item) {
                    x = document.getElementById('counter_body_update').insertRow(-1);
                    var i = x.insertCell(0);
                    var r = x.insertCell(1);
                    var e = x.insertCell(2);
                
                    i.innerHTML = item.section+'<input type="hidden" name="section_id_update[]" value='+item.sectionId+'><input type="hidden" name="sections_update[]" value="'+item.section+'">';
                    if(item.useInOut ==1){
                        r.innerHTML = '<input class="form-control" name="in_update[]" type="number" min="0"  value="'+item.start+'">';
                    }else{
                        r.innerHTML = '<input name="in_update[]" type="hidden" min="0" value="0">';
                    }
                   
                    e.innerHTML = '<input type="hidden" name="flag_update[]" value='+item.useInOut+'><input class="form-control" name="out_update[]" type="number" min="0"  value="'+item.end+'">';     
                });
            }
        });
    }

    
    function get_reject(machineId){
        return $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Reject/GetRejectHeaderByMachineId?iMachineCounterId='+machineId,
            dataType:'json'
        });
    }

    function get_rejects(id,line_number){
        return $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Reject/GetRejectDetails?iRejectHeaderId='+id+'&iLineNo='+line_number,
            dataType:'json'
        });
    }
</script>