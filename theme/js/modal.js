




$(document).on('click', '.update_data', function(){  
           var update_id = $(this).attr("id");  
           $.ajax({  
                url:"order.ajax.edit.php",  
                method:"post",  
                data:{update_id:update_id},  
                dataType:"json",  
                success:function(data){  
                     $('#status_pengiriman_m').val(data.status_pengiriman);  
                     $('#status_pembayaran_m').val(data.status_pembayaran); 
                     $('#update_id_m').val(data.id);  
                     $('#update').val("update");  
                     $('#update_data').modal('show');  
                }  
           });  
      });
$('#update_form').on("submit", function(event){  
           event.preventDefault();  
           if($('#status_pengiriman_m').val() == "")  
           {  
                alert("Status pengiriman harus diisi");  
           }  
           else if($('#status_pembayaran_m').val() == "")  
           {  
                alert("Status pembayaran harus diisi");  
           }  
           
           else  
           {  
                $.ajax({  
                     url:"order.ajax.update.php",  
                     method:"POST",
                     data:$('#update_form').serialize(),  
                     beforeSend:function(){  
                          $('#update').val("Updating");  
                     },  
                     success:function(data){  
                          $('#update_form')[0].reset();  
                          $('#update_data').modal('hide');  
                          $('#tbl_order').html(data);  
                     }  
                });  
           }  
      });
 
 

   $(document).on('click', '.lihat_data', function(){  
           var detail_order = $(this).attr("id");  
           $.ajax({  
                url:"order.ajax.tampil.php",  
                method:"post",  
                data:{detail_order:detail_order},  
                success:function(data){  
                     $('#detail_order').html(data);  
                     $('#confirm-detail').modal("show");  
               }  
                });  
           });


 