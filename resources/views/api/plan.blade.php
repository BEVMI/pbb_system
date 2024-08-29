<script>
    function uploadPlan(){
        let month_upload = document.getElementById('month_upload').value;
        let year_now = document.getElementById('year_now').value;
        let upload_file_irene =  $('#plan_upload')[0].files;
        let api_url = '{!!$api_url!!}';
        var fd = new FormData();
       
        fd.append('file',upload_file_irene[0]);

        $.ajax({
            type:'POST',
            method:'POST',
            url:api_url+'/MonthlyPlan/Upload?nYear='+year_now+'&nMonth='+month_upload+'',
            contentType: false,
            processData: false,
            enctype: 'multipart/form-data',
            data: fd,
            success:function(data){
                console.log(data);
            }
        });    
    }
</script>
