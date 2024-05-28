$(document).ready(function() {

    init_select2();
    
	$('#tableNo').focus();

});

function init_select2() {

    // Clear selection if Select2 has been initialized before
    if ($('#select22').hasClass("select2-hidden-accessible")) {
        $('#select22').val(null).trigger('change');
        $('#qty0').val(1);
    }

    $('#select22').select2({
        placeholder: 'Select Item',
        theme: 'bootstrap',
        selectOnClose: true,
        data: menu_items
    });
      
    $('#select22').on('select2:close', function (e) {
        $('#select22').focus();
    });    
      
  }

  function removeItem(){
      console.log('remove Item: ', this);
  }

  // Vue
  var app = new Vue({
      el: '#app',
      data: {items: []},
      methods: {
          addItem: function () {
                if($('#select22').select2('data')[0].id != ''){
                    $('#select22').select2('data')[0].qty = $('#qty0').val();
                    this.items.push($('#select22').select2('data')[0]);  
                    init_select2();
                }
                else{
                }
				$('#select22').focus();
          },
          removeItem: function(index) {
            console.log("remove item", index);
            this.items.splice(index,1);
          },
          submitItems: function(){
                if( this.items.length>0){
                    $.ajax({
                        url: "submit.php", 
                        type: 'POST',
                        data: {items: JSON.stringify(app.items), totalAmount: totalAmount, tableNo: $('#tableNo').val() },
                        success: function(response){ 
                            if(response != 'error'){
                                location.href = 'print.php?id='+response; 
                            }
                        }
                    });
                } else{
                    $('#select22').focus();
                }
          }
      },
      computed: {
          totalAmount() {
              totalAmount = this.items.reduce( function(totalAmount, item){
                return totalAmount + (item.price * item.qty) 
              }, 0);
              return totalAmount;
          }
      }
  });

  