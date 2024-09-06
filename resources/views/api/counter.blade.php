<script>
   
</script>

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
                "end": outs_post,
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
                "counterDetails":counterDetails
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
                    // searchRejects();
                    $('#modalCreate').modal('hide');
                }, "2000");
            }
        });
   
    }
</script>