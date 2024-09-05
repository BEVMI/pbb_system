<script>
    $(document).ready(function(){
        let get_month = {!!$month_now!!};
        let get_year = {!!$year_now!!};
        getJobs(get_month,get_year);
            Swal.fire({
            position: "center",
            icon: "success",
            title: "LOADING PLEASE WAIT",
            showConfirmButton: false,
            timer: 2500
        });
    });

    function searchJob(){
        let month_now = document.getElementById('month_now').value;
        let year_now = document.getElementById('year_now').value;       
        getJobs(month_now,year_now);
        Swal.fire({
            position: "center",
            icon: "success",
            title: "LOADING PLEASE WAIT",
            showConfirmButton: false,
            timer: 2500
        });
    }

    function getJobs(month,year){
        $('#job_body').empty();
        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Production/GetJobs?nYear='+year+'&nMonth='+month,
            success: function (data) {
                irene_parse = JSON.parse(data);
            
                $.each(irene_parse, function(index,item) {
                    var x = document.getElementById('job_body').insertRow(-1);
                    var i = x.insertCell(0);
                    var r = x.insertCell(1);
                    var e = x.insertCell(2);
                    var n = x.insertCell(3);
                    var j = x.insertCell(4);
                    var o = x.insertCell(5);
                    var y = x.insertCell(6);
                    var l = x.insertCell(7);

                    i.innerHTML = item.iJobNo;
                    r.innerHTML = formatDate(item.dJobDate);  
                    e.innerHTML = item.cStockCode;
                    n.innerHTML = item.cDescription;    
                    j.innerHTML = item.cLongDesc;      
                    o.innerHTML = item.nQtyToMake;   
                    y.innerHTML = item.nQtyProduce;   
                    l.innerHTML = item.cStatus;             
              
                });
            }
        });
    }
</script>

<script>
    function verifyJob(){
        document.getElementById('job_section').style.display = 'none';
        document.getElementById('job_section_1').style.display = 'none';
        
        document.getElementById('stock_code').value = '';
        document.getElementById('qty_to_make').value = '';
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
            get_job(job_number).done(function(irene_parse){
                document.getElementById('job_section').style.display = 'flex';
                document.getElementById('job_section_1').style.display = 'flex';
                document.getElementById('stock_code').value = irene_parse[0].cStockCode;
                document.getElementById('qty_to_make').value = irene_parse[0].nQtyToMake;
            });
        }
    }

    function get_job(job_number){
        return $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Production/GetJobSysproDetails?ijob='+job_number,
            dataType:'json'
        });
    }

    function job_creation(){
        let month_now = document.getElementById('month_now').value;
        let year_now = document.getElementById('year_now').value;   
        let job_number = document.getElementById('job_number').value;
        get_job(job_number).done(function(irene_parse){
            $.ajax({
                type:'POST',
                method:'POST',
                url:api_url+'/Production/CreateJob',
                crossDomain: true,
                dataType: 'json',
                headers: { 
                    'Accept': 'application/json',
                    'Content-Type': 'application/json' 
                },
                data:  JSON.stringify({
                    'iPlanId':0,
                    'iJobNo':job_number,
                    'dJobDate':irene_parse[0].dJobDate,
                    'nQtyToMake':irene_parse[0].nQtyToMake,
                    'cStockCode':irene_parse[0].cStockCode,
                    'cDescription':irene_parse[0].cDescription,
                    'cLongDesc':irene_parse[0].cLongDesc,
                    'cStatus':'Pending',
                    'nQtyProduce':0
                }),
                success:function(data){
                    if(data.indexOf("Column1") > -1){
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: "STOCK CODE DOES NOT EXIST",
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }else{
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "SUCCESSFULLY SAVED",
                            showConfirmButton: false,
                            timer: 2000
                        });
                        setTimeout(() => {
                            getJobs(month_now,year_now);
                                $('#modalCreate').modal('hide');
                                document.getElementById('job_section').style.display = 'none';
                                document.getElementById('job_section_1').style.display = 'none';
                                document.getElementById('stock_code').value = '';
                                document.getElementById('qty_to_make').value = '';
                            }, "2000");
                        }
                    }
                });    
            });
    }

    function hideJob(){
        document.getElementById('job_section').style.display = 'none';
        document.getElementById('job_section_1').style.display = 'none';
        document.getElementById('stock_code').value = '';
        document.getElementById('qty_to_make').value = '';
    }

    function resetJobFields(){
        document.getElementById('job_section').style.display = 'none';
        document.getElementById('job_section_1').style.display = 'none';
        document.getElementById('job_number').value = '';
        document.getElementById('stock_code').value = '';
        document.getElementById('qty_to_make').value = '';
    }
</script>