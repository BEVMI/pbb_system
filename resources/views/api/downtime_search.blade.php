<script>
    load();
    function refresh(){
        ifvisible.off('idle');
        ifvisible.setIdleDuration('{!!$idletime!!}'); // Page will become idle after 120 seconds
        ifvisible.on("idle", function(){
           load();
        });

    }
    function load(){
        $(document).ready(function(){
            let month = document.getElementById('month_now').value;
            let year = document.getElementById('year_now').value;
            let line = document.getElementById('line_search').value;
            let job = document.getElementById('job_search').value;
            getDowntime(month,year,line,job);
        });
    }

    function getDowntime(month,year,line,job){
        
        if(!job){
            job_param = '';
        }else{
            job_param = '&iJobNo='+job;
        }
      
        Swal.fire({
            position: "center",
            icon: "success",
            title: "LOADING PLEASE WAIT",
            showConfirmButton: false,
            timer: 2500
        });
        $('#downtime_main_body_table').empty();
        ifvisible.off('idle');
        
        refresh();

        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Downtime/GetDowntimeHeaders?nYear='+year+'&nMonth='+month+job_param+'&iLineId='+line,
            success: function (data) {
                irene_parse = JSON.parse(data);
              
                
                $.each(irene_parse, function(index,item) {
                    var x = document.getElementById('downtime_main_body_table').insertRow(-1);
                    var i = x.insertCell(0);
                    var r = x.insertCell(1);
                    var e = x.insertCell(2);
                    var n = x.insertCell(3);
                    var j = x.insertCell(4);

                    let edit = '<button class="btn btn-success" onclick="updateDowntime('+item.id+','+item.iLineId+')" style="margin:0;"><i class="fa-solid fa-pencil"></i></button> &nbsp;';

                    i.innerHTML = item.iJobNo;
                    r.innerHTML = formatDate(item.dDate);
                    e.innerHTML = item.iShiftLength;
                    n.innerHTML = item.cCreatedBy;
                    j.innerHTML = edit;

                }); 
            }
        });
    }

    function search(){
        load();
    }
</script>