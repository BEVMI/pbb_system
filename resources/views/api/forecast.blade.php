<script>
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');   
</script>
<script src="{{asset('js/select2.min.js')}}"></script>
<script>
    
    let current_year = '{!!$year_now!!}';
    searchForecast(current_year);
    function searchForecast(year){
        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Forecast/GetForecastHeader?nYear='+year,
            processData: false,
            success: function (data) {
                irene_parse = JSON.parse(data);
                $.each(irene_parse, function(index,item) {
                    var x = document.getElementById('get_header_forecast').insertRow(-1);
                
                    var i = x.insertCell(0);
                    var r = x.insertCell(1);
                    var e = x.insertCell(2);
                    var n = x.insertCell(3);
                    
                    if(item.nMonth===1){
                        post_month = 'JANUARY';
                    }

                    if(item.nMonth===2){
                        post_month = 'FEBRUARY';
                    }

                    if(item.nMonth===3){
                        post_month = 'MARCH';
                    }

                    if(item.nMonth===4){
                        post_month = 'APRIL';
                    }

                    if(item.nMonth===5){
                        post_month = 'MAY';
                    }

                    if(item.nMonth===6){
                        post_month = 'JUNE';
                    }

                    if(item.nMonth===7){
                        post_month = 'JULY';
                    }

                    if(item.nMonth===8){
                        post_month = 'AUGUST';
                    }

                    if(item.nMonth===9){
                        post_month = 'SEPTEMBER';
                    }

                    if(item.nMonth===10){
                        post_month = 'OCTOBER';
                    }

                    if(item.nMonth===11){
                        post_month = 'NOVEMBER';
                    }

                    if(item.nMonth===12){
                        post_month = 'DECEMBER';
                    }

                    i.innerHTML = item.id;
                    r.innerHTML = post_month;
                    e.innerHTML = item.nYear;
                    n.innerHTML = '<a href="#" class="btn btn-success mt-2 mt-xl-0 view_data" data-bs-toggle="modal" data-bs-target="#modalView" data-id="'+item.id+'"> <i class="fas fa-eye"></i></a>&nbsp;<a onclick="confirmDeleteForecastHeader('+item.id+')" href="#" class="btn btn-danger mt-2 mt-xl-0"><i class="fa-solid fa-trash"></i></a>';
                });

            },
            error: function() { 
            }
        });
    }

    function searchForecastFilter(){
        Swal.fire({
            position: "center",
            icon: "success",
            title: "PLEASE WAIT",
            showConfirmButton: false,
            timer: 2000
        });
        $('#get_header_forecast').empty();
        let year_now = document.getElementById('year_now').value;
        searchForecast(year_now);
    }
</script>

<script>
    function myFunction() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput").value;
      filter = input.toUpperCase();
      table = document.getElementById("get_header_forecast");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }       
      }
    }
    </script>

<script>
    function ireneCheck(){
        let url = '{!!$api_url!!}';
        
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");  
        let upload_file_irene =  $('#forecast_upload')[0].files;
        var fileType = $('#forecast_upload').val().split('.').pop();
       
        var fileType = upload_file_irene[0].name.split('.').pop();
        
        if (fileType != 'xlsx'){            
            setTimeout(function(){
                $('#finalize').modal('hide');     
            }, 2000);


            setTimeout(function(){
                $('#modalCreate').modal('show');
            }, 2500);
          
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Please Upload an Excel file",
                showConfirmButton: false,
                timer: 3000
            });

          
        }else{
            var fd = new FormData();
                fd.append('file',upload_file_irene[0]);
                fd.append('_token',CSRF_TOKEN);

                $.ajax({
                type:'POST',
                url:"{{ route('forecast.check') }}",
                contentType: false,
                processData: false,
                data: fd,
                success:function(data){
                    $('#ireneTable2').empty();
                    console.log(data);
                    data.forEach(function(irene, index) {
                        var x =document.getElementById('ireneTable2').insertRow(-1);
                        irene.forEach(function(irene2, index2) { 
                            x.insertCell(index2).innerHTML = irene2
                        });
                    });
                }
            });
        }    
    }

    function ireneUpload(){
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");  
        let upload_file_irene =  $('#forecast_upload')[0].files;
        
        var fd = new FormData();
        fd.append('file',upload_file_irene[0]);
        fd.append('_token',CSRF_TOKEN);
        $.ajax({
            type:'POST',
            url:"{{ route('forecast.store') }}",
            contentType: false,
            processData: false,
            data: fd,
            success:function(data){
                $.ajax({
                    type:'post',
                    headers: {  'Access-Control-Allow-Origin': '*' },
                    url:api_url+'/Forecast/UploadForecast',
                    data: JSON.stringify(data),
                    crossDomain: true,
                    dataType: 'json',
                    contentType: "application/json; charset=utf-8",
                    success:function(data){
                        location.reload();
                    }
                });
            }
        });    
    }
</script>

<script>
        $(document).ready(function(){
            $(document).on('click', '.view_data', function (e) {
                let id = $(this).data('id');
                
                document.getElementById('forecast_header_id').value = id;
                load_stock_code_detail(id,api_url)
            });            
        });
</script>

<script>
    function updateForecastDetail(id,header_id){
        let id_post = id;
        

        let nQty = document.getElementById('nQyt'+id_post).value;
        let cStockCode = document.getElementById('cStockCode'+id_post).value;
        var form_detail = new FormData();
       
        let irene_data = {
            id:id_post,
            nQty:nQty,
            cStockCode:cStockCode
        };

        $.ajax({
            type:'post',
            headers: {  'Access-Control-Allow-Origin': '*' },
            url:api_url+'/Forecast/UpdateForecastDetail',
            data: JSON.stringify(irene_data),
            crossDomain: true,
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            success:function(data){
               

            } 
        });
        $('#modalView').modal('hide')
        Swal.fire({
                position: "center",
                icon: "success",
                title: "Stock Code Successfully Updated",
                showConfirmButton: false,
                timer: 3000
        });
        setTimeout(function(){
            load_stock_code_detail(header_id,api_url)
            $('#modalView').modal('show')
        }, 2000);
    }
</script>

<script>
    function load_stock_code_detail(id,api_url){
        $('#ireneTable4').empty();
        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Forecast/GetForecastDetail/',
            data: {
                iHeaderId:id
            },
            
            success: function (data) {
                irene_parse = JSON.parse(data);
                $.each(irene_parse, function(index,item) {
                    var x = document.getElementById('ireneTable4').insertRow(-1);
                    var i = x.insertCell(0);
                    var r = x.insertCell(1);
                    var e = x.insertCell(2);
                    var n = x.insertCell(3);
                    var j = x.insertCell(4);
                    var o = x.insertCell(5);

                    i.innerHTML = item.id+'<input type="hidden" id="detail_id" value="'+item.id+'">';
                    r.innerHTML = '<select id="cStockCode'+item.id+'" data-select2-id="'+item.id+'" class="pbb_stockcode form-control" ><option selected>'+item.cStockCode+'</option></select>';
                    e.innerHTML = item.cDescription;
                    n.innerHTML = item.cLongDesc;
                    j.innerHTML = '<input id="nQyt'+item.id+'" type="text" class="form-control search_now" value='+item.nQty+' />';
                    o.innerHTML = '<a onclick="updateForecastDetail('+item.id+','+id+')" href="#" class="btn btn-success mt-2 mt-xl-0"><i class="fa-solid fa-arrow-right"></i></a>&nbsp;<a onclick="confirmDeleteForecastDetail('+item.id+','+id+')" href="#" class="btn btn-danger mt-2 mt-xl-0"><i class="fa-solid fa-trash"></i></a>';
                });


                
                $( ".pbb_stockcode" ).select2({
                    dropdownParent: $("#modalView").parent(),
                    ajax: { 
                        url: '{{url("/pbb_stockcode")}}',
                        type: "post",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                        return {
                            _token: CSRF_TOKEN,
                            search: params.term // search term
                            };
                        },
                        processResults: function (response) {
                        return {
                            results: response.data
                            };
                        },
                        cache: true
                    }
                });

                $('.pbb_stockcode').on('select2:select', function (e) {
                    var data = e.params.data;
                    id = $(this).closest("tr").find('td:first').text();
                    header_id = document.getElementById('forecast_header_id').value;
                    updateForecastDetail(id,header_id)
                });
            }
        });
    } 
</script>
    
<script>
    function confirmDeleteForecastDetail(id,header_id){
        Swal.fire({
            title: 'Do you want to delete this Stock Code?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Yes',
            denyButtonText: 'No',
            customClass: {
                actions: 'my-actions',
                cancelButton: 'order-1 right-gap',
                confirmButton: 'order-2',
                denyButton: 'order-3',
            },
            }).then((result) => {
            if (result.isConfirmed) {
               deleteForecastDetail(id,header_id)
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })
    }
</script>

<script>
    function deleteForecastDetail(id,header_id){
        let id_post = id;
        let irene_data = {
            iDetailId:id_post, 
        };
        
        $.ajax({
            type:'post',
            headers: {  'Access-Control-Allow-Origin': '*' },
            url:api_url+'/Forecast/DeleteForecastDetail?iDetailId='+id_post,
            crossDomain: true,
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            success:function(data){
                console.log(data);
            } 
        });
        $('#modalView').modal('hide')
        Swal.fire({
                position: "center",
                icon: "success",
                title: "Stock Code Successfully Deleted",
                showConfirmButton: false,
                timer: 3000
        });
        setTimeout(function(){
            load_stock_code_detail(header_id,api_url)
            $('#modalView').modal('show')
        }, 2000);

    }
</script>

<script>
    function confirmDeleteForecastHeader(id){
        Swal.fire({
            title: 'Do you want to delete this Forecast?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Yes',
            denyButtonText: 'No',
            customClass: {
                actions: 'my-actions',
                cancelButton: 'order-1 right-gap',
                confirmButton: 'order-2',
                denyButton: 'order-3',
            },
            }).then((result) => {
            if (result.isConfirmed) {
                deleteForecastHeader(id)
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })
    }
</script>

<script>
    function deleteForecastHeader(id){
        let id_post = id;
       
        $.ajax({
            type:'post',
            headers: {  'Access-Control-Allow-Origin': '*' },
            url:api_url+'/Forecast/DeleteForecastHeader?iHeaderId='+id_post,
            crossDomain: true,
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            success:function(data){
            } 
        });
  
        Swal.fire({
                position: "center",
                icon: "success",
                title: "Forecast Successfully Deleted",
                showConfirmButton: false,
                timer: 3500
        });

        setTimeout(function(){
            location.reload();
        }, 3500);
    }
</script>
