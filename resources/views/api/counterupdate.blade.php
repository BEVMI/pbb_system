<script>
    function updateAll(){
        let header_id = document.getElementById('hidden_header_id').value;
        
        counterUpdateDetails = [];
        Swal.fire({
            position: "center",
            icon: "success",
            title: "SUCCESSFULLY UPDATE",
            showConfirmButton: false,
            timer: 5000
        });

        updateCounter(header_id);
        updateDowntime(header_id);
        updateReject(header_id);
        let outs_update = document.getElementsByName('out_update[]');
        let check_pallet = outs_update[5].value;
        let month_now_start = document.getElementById('month_now').value;
        let year_now = document.getElementById('year_now').value;
        let line_start = document.getElementById('line_search').value
        // if(check_pallet>0){
        //     var base_url =  '{{ url("/")}}';
        //     let title = 'JOB '+job_number_update+' MACHINE COUNTER IS CREATED';
        //     let content = 'PLEASE CREATE A PALLET FOR JOB '+job_number_update;
        //     let department = 'production1';
        //     setTimeout(() => {
        //         $.ajax({
        //         type: 'GET', //THIS NEEDS TO BE GET
        //         url: base_url+'/api/emailSend/'+title+'/'+content+'/'+department,
        //         success: function (data) { 
        //         }
        //     });
        //     }, "1000");
        // }
        

        setTimeout(() => {
            getCounter(line_start,year_now,month_now_start);
            $('#modalView').modal('hide');
        }, "2000");
    }
    function updateCounter(header_id){
        let line = document.getElementById('lines_update').value;
        let line_name = $("#lines_update option:selected").text();
        let iLossPalletUpdate = document.getElementById('iLossPalletUpdate').value;

        let value = document.getElementById('job_number_update').value;
        let split_update = value.split("_");
        let job_number_update = split_update[0];
        let id_now_update = split_update[1];

        let sections_update = document.getElementsByName('sections_update[]');
        let section_id_update = document.getElementsByName('section_id_update[]');
        let ins_update = document.getElementsByName('in_update[]');
        let outs_update = document.getElementsByName('out_update[]');
        let flag_update = document.getElementsByName('flag_update[]');
        let counterUpdateDetails = [];
        
        let line_start = document.getElementById('line_search').value;
        let month_now_start = document.getElementById('month_now').value;
        let year_now = document.getElementById('year_now').value;
        let initial_date = document.getElementById('date_update').value;
        let cEncodedBy = "{!!$user_auth->name!!}";
        // getCounter(line_start,year_now,month_now_start);

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
        console.log(fbo_update);
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
                "iLossPallet":iLossPalletUpdate,
                "iJobId":id_now_update,
                "machineCounterHeaderId": header_id,
                "counterDetails":counterUpdateDetails,
                "countDate":initial_date,
                "cEncodedBy":cEncodedBy,
                "fbo":fbo_update,
                "lbo":lbo_update
            }),
            success:function(data){
                
            }
        });
    }

    function get_downtime_header(machineId){
        return $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Downtime/GetDowntimeDetailsByMachineId?iMachineCounterId='+machineId,
            dataType:'json'
        });
    }

    function updateDowntime(header_id){
        //MAIN
        get_downtime_header(header_id).done(function(irene_parse){
            console.log(irene_parse);
            let id = irene_parse.id;
            let job = irene_parse.jobNo;
            let lines = document.getElementById('lines_update').value;
            let created_by = "{!!$user_auth->name!!}";
            let shift_length_create = document.getElementById('shiftLength_update').value;
            let downtime_date_update = document.getElementById('date_update').value;
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
                }
            });
        });
        
    }


    function updateReject(machine_id){
        get_reject(machine_id).done(function(irene_parse){
            console.log(irene_parse);
            let materialId = document.getElementsByName('materialIdUpdate[]');
            let sectionId = document.getElementsByName('sectionIdUpdate[]');
            let section = document.getElementsByName('sectionUpdate[]');
            let materials = document.getElementsByName('materialsUpdate[]');
            let qty = document.getElementsByName('qtyUpdate[]');
            let rejectDetailsUpdate = [];

            let lines = irene_parse[0].iLineId;
            let job_number = irene_parse[0].iJobNo;
            let lost_case = document.getElementById('iLossPalletReject_update').value;
            let initial_date = document.getElementById('date_update').value;
            let header_id = irene_parse[0].id
            
            let cEncodedBy = "{!!$user_auth->name!!}"
            for (var i = 0; i <materialId.length; i++) {
                let material_id=materialId[i].value;
                let section_id=sectionId[i].value;
                let section_post=section[i].value;
                let materials_post=materials[i].value;
                let qty_post=qty[i].value;
                
                rejectDetailsUpdate.push({
                    "materialId": material_id,
                    "sectionId": section_id,
                    "section": section_post,
                    "materials": materials_post,
                    "qty": qty_post
                });
            }

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

            $.ajax({
                type:'POST',
                method:'POST',
                url:api_url+'/Reject/UpdateRejectHeader',
                crossDomain: true,
                dataType: 'json',
                headers: { 
                    'Accept': 'application/json',
                    'Content-Type': 'application/json' 
                },
                data:  JSON.stringify({
                    "lossCase": lost_case,
                    "lineId": lines,
                    "rejectHeaderId": header_id,
                    "jobNo": job_number,
                    "lossCase": lost_case,
                    "rejectDetails":rejectDetailsUpdate,
                    "rejectDate":initial_date,
                    "cEncodedBy":cEncodedBy,
                    "fbo":fbo_update,
                    "lbo":lbo_update,
                    "iMachineCounterId": machine_id
                }),
                success:function(data){
                    rejectDetailsUpdate = [];
                }
            });
        });
        
    }
</script>