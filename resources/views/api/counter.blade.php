<script>
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
                        r.innerHTML = '<input class="form-control" name="in_create[]" type="number" min="0"  value="0">';
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
            if(!job_number){
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "PLEASE FILL UP THE JOB FIELD",
                    showConfirmButton: false,
                    timer: 2500
                });
            }else{
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
       
        let job_number = document.getElementById('job_number').value;
        let sections_post = document.getElementsByName('sections_create[]');
        let section_id_post = document.getElementsByName('section_id[]');
        let ins_post = document.getElementsByName('in_create[]');
        let outs_post = document.getElementsByName('out_create[]');
        let flag_post = document.getElementsByName('flag[]');
        let counterDetails = [];
        let initial_date = "{!!$initial_date!!}";
        let cEncodedBy = "{!!$user_auth->name!!}";

        let line_start = document.getElementById('line_search').value;
        let month_now_start = document.getElementById('month_now').value;
        let year_now = document.getElementById('year_now').value;

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
                "machineCounterHeaderId": 0,
                "jobNo": job_number,
                "cEncodedBy":cEncodedBy,
                "counterDetails":counterDetails,
                "countDate":initial_date
            }),
            success:function(data){
                counterDetails = [];
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "SUCCESSFULLY SAVED",
                    showConfirmButton: false,
                    timer: 2000
                });
                setTimeout(() => {
                    getCounter(line_start,year_now,month_now_start);
                    $('#modalCreate').modal('hide');
                }, "2000");
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
        });            
    });

    function load_detail(id,line){
        $('#counter_body_update').empty();
        document.getElementById('lines_update').value = line;
        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/MachineCounter/GetMachineCounterDetails?iMachineCounterHeaderId='+id+'&iLineNo='+line,
            success: function (data) {
                irene_parse = data;
                document.getElementById('job_number_update').value = irene_parse.jobNo;
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
                   
                    e.innerHTML = '<input type="hidden" name="flag_update[]" value='+item.useInOut+'><input class="form-control" name="out_create[]" type="number" min="0"  value="'+item.end+'">';     
                });
            }
        });
    }

    function updateCounter(){
        let line = document.getElementById('lines_update').value;
        let line_name = $("#lines_update option:selected").text();
        let header_id = document.getElementById('hidden_header_id').value;
        let job_number_update = document.getElementById('job_number_update').value;
        let sections_update = document.getElementsByName('sections_update[]');
        let section_id_update = document.getElementsByName('section_id_update[]');
        let ins_update = document.getElementsByName('in_update[]');
        let outs_update = document.getElementsByName('out_create[]');
        let flag_update = document.getElementsByName('flag_update[]');
        let counterUpdateDetails = [];
        
        let line_start = document.getElementById('line_search').value;
        let month_now_start = document.getElementById('month_now').value;
        let year_now = document.getElementById('year_now').value;
        let initial_date = "{!!$initial_date!!}";
        let cEncodedBy = "{!!$user_auth->name!!}";
        // getCounter(line_start,year_now,month_now_start);
        for (var i = 0; i < section_id_update.length; i++) {
            let section_id=section_id_update[i].value;
            let ins=ins_update[i].value;
            let outs=outs_update[i].value;
            let sections = sections_update[i].value;
            let flag = flag_update[i].value;
            counterUpdateDetails.push({
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
                "jobNo": job_number_update,
                "machineCounterHeaderId": header_id,
                "counterDetails":counterUpdateDetails,
                "countDate":initial_date,
                "cEncodedBy":cEncodedBy,
            }),
            success:function(data){
                counterUpdateDetails = [];
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "SUCCESSFULLY UPDATE",
                    showConfirmButton: false,
                    timer: 2000
                });
                setTimeout(() => {
                    getCounter(line_start,year_now,month_now_start);
                    $('#modalView').modal('hide');
                }, "2000");
            }
        });
    }
</script>