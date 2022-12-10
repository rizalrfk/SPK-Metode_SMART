 function confirm_modal(delete_url)
        {
          $('#modal_delete').modal('show', {backdrop: 'static'});
          document.getElementById('delete_link').setAttribute('href' , delete_url);
        }


$('input.typeahead').typeahead({
       source:  function (query, process) {
       return $.get('ajax.php', { query: query }, function (data) {
         console.log(data);
         data = $.parseJSON(data);
         return process(data);
        });
       }
      });

 $(function(){

        $("#tanggal").datepicker({
    
      format:'dd-mm-yyyy'
        });
                });

     $(function(){
        $("#tanggal2").datepicker({
    
      format:'dd-mm-yyyy'
        });
                });
      $(function(){
        $("#tanggal3").datepicker({
    
      format:'dd-mm-yyyy'
        });
                });
       $(function(){
        $("#tanggal4").datepicker({
    
      format:'dd-mm-yyyy'
        });
                });
     