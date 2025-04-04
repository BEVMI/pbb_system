<script>
    $(document).ready(function(){
        let get_source = 'Plan';
        let get_type = 'Summary';
        let get_month = {!!$month_now!!};
        let get_year = {!!$year_now!!};

        getMaterials(get_month,get_year,get_source,get_type);
    });
</script>

<script>
    function computeMaterials(){
        let month = document.getElementById('month_now').value;
        let year_now = document.getElementById('year_now').value;
        let source = document.getElementById('source').value;
        

        $.ajax({
            type:'POST',
            method:'POST',
            url:api_url+'/Mrp/ComputeMaterials?nYear='+year_now+'&nMonth='+month+'&cSource='+source,
            contentType: false,
            processData: false,
            success:function(data){
                Swal.fire({
                position: "center",
                icon: "success",
                title: "COMPUTATION SUCCESSFULLY",
                showConfirmButton: false,
                timer: 2500
            });

            setTimeout(function(){
                    location.reload();
                }, 2500);
            }
        });    
    }
</script>

<script>
    function getComputed(){
        let get_month = document.getElementById('get_month').value;
        let get_year = document.getElementById('get_year').value;
        let get_source = document.getElementById('get_source').value;
        let get_type = document.getElementById('get_type').value;

        getMaterials(get_month,get_year,get_source,get_type);
    }
</script>

<script>
     function getMaterials(get_month,get_year,get_source,get_type){
        
        let base_url = '{!!$irene_base_url!!}';
        $('#get_header').empty();

        Swal.fire({
            position: "center",
            icon: "success",
            title: "LOADING PLEASE WAIT",
            showConfirmButton: false,
            timer: 2000
        });
        if(get_type  === 'Summary'){
            document.getElementById('table-plan').style.display = 'block';
            document.getElementById('table-detail').style.display = 'none';
            $.ajax({
                type: 'GET', //THIS NEEDS TO BE GET
                url: api_url+'/Mrp/GetComputedMaterials?nYear='+get_year+'&nMonth='+get_month+'&cSource='+get_source+'&cType='+get_type,
                success: function (data) {
                    irene_parse = JSON.parse(data);
                
                    $.each(irene_parse, function(index,item) {
                        var x = document.getElementById('get_header').insertRow(-1);
                        if(item.nToOrder > 0){
                            irene1 =  item.nToOrder.toFixed(2);
                            x.className = "red";
                        }else{
                            irene1 = '-';
                        }

                        if(item.dDeliveryDate == null){
                            irene2 = '';
                        }else{
                            irene2 = formatDate(item.dDeliveryDate);
                        }
                        
                        if(item.cRemarks == null){
                            irene3 = '';
                        }else{
                            irene3 = item.cRemarks;
                        }
                        
                        var i = x.insertCell(0);
                        var r = x.insertCell(1);
                        var e = x.insertCell(2);
                        var n = x.insertCell(3);
                        var j = x.insertCell(4);
                        var o = x.insertCell(5);
                        var y = x.insertCell(6);
                        var l = x.insertCell(7);
                     
                        i.innerHTML = item.cAlternateKey1;  
                        r.innerHTML = item.nOnHand.toFixed(2);    
                        e.innerHTML = item.nOnOrder.toFixed(2);      
                        n.innerHTML = item.nTotalRequired.toFixed(2);   
                        j.innerHTML = irene1;
                        o.innerHTML = irene2;                                    
                        y.innerHTML = irene3;      
                        l.innerHTML = '<a href="#" class="btn btn-success mt-2 mt-xl-0 view_data" data-bs-toggle="modal" data-bs-target="#modalView" data-ddeliverydate="'+irene2+'" data-cremarks="'+irene3+'" data-stockcode="'+item.cAlternateKey1+'"><span><i class="fas fa-eye"></i></span></a>';   
                    });
                }
            });
        }
        else{
            document.getElementById('table-plan').style.display = 'none';
            document.getElementById('table-detail').style.display = 'block';
            document.getElementById("detail_frame").src=base_url+'/mrp_detail/'+get_month+'/'+get_year+'/'+get_source;
        }
    }
</script>

<script>
    function sufficient(){
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value;
        table = document.getElementById("get_header");
        tr = table.getElementsByTagName("tr");
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[6];
            if(filter == 1){
                if(td.innerHTML != '-'){
                    tr[i].style.display = "";
                }else{
                    tr[i].style.display = "none";
                }
            }else{
                if(td.innerHTML == '-'){
                    tr[i].style.display = "";
                }else{
                    tr[i].style.display = "none";
                }
            }

        }
    }
</script>

<script>
    $(document).ready(function(){
        $(document).on('click', '.view_data', function (e) {
            let dDeliveryDate = $(this).data('ddeliverydate');
            let cRemarks = $(this).data('cremarks');
            let stockCode = $(this).data('stockcode');
            if(cRemarks === undefined){
                post_remarks = '';
            }else{
                post_remarks = cRemarks;
            }
            document.getElementById('post_stockcode').value = stockCode;
            document.getElementById('post_dDeliveryDate').value = dDeliveryDate;
            document.getElementById('post_cRemarks').value = post_remarks;

        });            
    });
</script>
<script>
    function updateMrp(){
        let get_month = document.getElementById('get_month').value;
        let get_year = document.getElementById('get_year').value;
        let get_source = document.getElementById('get_source').value;
        let type = 'Summary';

        let delivery = document.getElementById('post_dDeliveryDate').value;
        let remarks =  document.getElementById('post_cRemarks').value;
        let stockcode = document.getElementById('post_stockcode').value;
        $.ajax({
            type:'POST',
            method:'POST',
            url:api_url+'/Mrp/updateComputedMaterials?nYear='+get_year+'&nMonth='+get_month+'&cSource='+get_source+'&cStockcode='+stockcode+'&dDeliveryDate='+delivery+'&cRemarks='+remarks,
            contentType: false,
            processData: false,
            success:function(data){
                Swal.fire({
                position: "center",
                icon: "success",
                title: "REMARKS SUCCESSFULLY UPDATED",
                showConfirmButton: false,
                timer: 2500
            });

            setTimeout(function(){
                getMaterials(get_month,get_year,get_source,type);
                $('#modalView').modal('hide')
            }, 2500);
            }
        });    
    }
</script>