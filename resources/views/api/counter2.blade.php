<script>
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

    function irene(flag){ 
        if(flag===0){
            let line = document.getElementById('lines').value;
            let job_date = document.getElementById('date_counter').value;
            let value = document.getElementById('job_number').value;

            let split = value.split("_");
            let job_number = split[0];
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
    }

    function sum(total){
        const sum = total.reduce((partialSum, a) => partialSum + a, 0);
        return sum;
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

    function create_downtime(machine_id){
        //MAIN
        let value = document.getElementById('job_number').value;
        let split = value.split("_");
        let job_number = split[0];
        
        let id_now = split[1];
        let lines = document.getElementById('lines').value;
        let created_by = "{!!$user_auth->name!!}";
        let date = document.getElementById('date_counter').value;
        let dFgCases = document.getElementById('dFgCases').value;
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
        
        let shift_length_create = document.getElementById('shiftLength').value;
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
                "iMachineCounterId":machine_id,
                "lineId": lines,
                "jobNo": job_number,
                "shiftLength": shift_length_create,
                "createdBy":created_by,
                "downtimeDate":date,
                "machineDowntime":mcdDetails,
                "expectedDowntime":expDetails,
                "unexpectedDowntime":unexpDetails,
                "dFgCases":dFgCases,
                "fbo":fbo,
                "lbo":lbo,
            }),
            success:function(data){
                console.log(data);
                expDetails = [];
                unexpDetails = [];
                mcdDetails = [];
                $('#machine_body').empty();
                $('#expected_downtime_body').empty();
                $('#unexpected_downtime_body').empty();
            }
        });
    }
</script>