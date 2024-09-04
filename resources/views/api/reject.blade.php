<script>
    $(document).ready(function(){
        let get_month = {!!$month_now!!};
        let get_year = {!!$year_now!!};
        let line_default = 1;
        getRejects(get_month,get_year,line_default);
            Swal.fire({
            position: "center",
            icon: "success",
            title: "LOADING PLEASE WAIT",
            showConfirmButton: false,
            timer: 2500
        });
    });
</script>
<script>
    function searchRejects(){
        let month_now = document.getElementById('month_now').value;
        let year_now = document.getElementById('year_now').value;
        let line_search = document.getElementById('line_search').value;
        getRejects(month_now,year_now,line_search);
            Swal.fire({
            position: "center",
            icon: "success",
            title: "LOADING PLEASE WAIT",
            showConfirmButton: false,
            timer: 2500
        });
    }
</script>
<script>
    function getRejects(month,year,line_default){
        $('#reject_body_table').empty();
        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Reject/GetRejectHeaders?iLineId='+line_default+'&nYear='+year+'&nMonth='+month,
            success: function (data) {
                irene_parse = JSON.parse(data);
                $.each(irene_parse, function(index,item) {
                    var x = document.getElementById('reject_body_table').insertRow(-1);
                    var i = x.insertCell(0);
                    var r = x.insertCell(1);
                    var e = x.insertCell(2);
                    var n = x.insertCell(3);
                    var j = x.insertCell(4);

                    i.innerHTML = item.iLineId;
                    r.innerHTML = item.iJobNo;
                    e.innerHTML = formatDate(item.dDate);  
                    n.innerHTML = item.iLossCase;
                    j.innerHTML = '<a href="#" class="btn btn-success mt-2 mt-xl-0 modalView" data-bs-toggle="modal" data-bs-target="#modalView" data-id="'+item.id+'" data-line="'+item.iLineId+'"> <i class="fas fa-eye"></i></a>';    
               
                });
            }
        });
    }
</script>
<script>
    function choose_line(){
        let line = document.getElementById('lines').value;
        let job_number = document.getElementById('job_number').value;
        if(!job_number){
            Swal.fire({
                position: "center",
                icon: "error",
                title: "JOB NUMBER FIELD IS EMPTY",
                showConfirmButton: false,
                timer: 2000
            });
        }else{
            get_rejects(0,line).done(function(irene_parse){
                let details = irene_parse.rejectDetails;
                document.getElementById('post_reject').style.display = 'block';
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
        }
    }
</script>

<script>
    function get_rejects(id,line_number){
        return $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Reject/GetRejectDetails?iRejectHeaderId='+id+'&iLineNo='+line_number,
            dataType:'json'
        });
    }
</script>

<script>
    function postReject(){
        let materialId = document.getElementsByName('materialId[]');
        let sectionId = document.getElementsByName('sectionId[]');
        let section = document.getElementsByName('section[]');
        let materials = document.getElementsByName('materials[]');
        let qty = document.getElementsByName('qty[]');
        let rejectDetails = [];
        let lines = document.getElementById('lines').value;
        let job_number = document.getElementById('job_number').value;
        let lost_case = document.getElementById('lost_case').value;
        let initial_date = "{!!$initial_date!!}";
        for (var i = 0; i <materialId.length; i++) {
            let material_id=materialId[i].value;
            let section_id=sectionId[i].value;
            let section_post=section[i].value;
            let materials_post=materials[i].value;
            let qty_post=qty[i].value;
            
            rejectDetails.push({
                "materialId": material_id,
                "sectionId": section_id,
                "section": section_post,
                "materials": materials_post,
                "qty": qty_post
            });
        }

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
                "lineId": lines,
                "line": "",
                "rejectHeaderId": 0,
                "jobNo": job_number,
                "lossCase": lost_case,
                "isValidated": 0,
                "validatedBy": "",
                "rejectDetails":rejectDetails,
                "rejectDate": initial_date
            }),
            success:function(data){
                rejectDetails = [];
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "SUCCESSFULLY SAVED",
                    showConfirmButton: false,
                    timer: 2000
                });
                setTimeout(() => {
                    // refresh();
                    $('#modalCreate').modal('hide');
                }, "2000");
            }
        });    
    }
</script>

<script>
    function hideFields(){
        $('#reject_body').empty();
        document.getElementById('post_reject').style.display = 'none';
    }
</script>

<script>
    $(document).ready(function(){
        $(document).on('click', '.modalView', function (e) {
            let id = $(this).data('id');
            console.log(id);
        });
    });
</script>
