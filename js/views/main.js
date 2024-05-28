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

// Vue
var app = new Vue({
    el: '#app',
    data: {
        items: [],
        discount_percent: '0',
        discount_remarks: '',
        // tax_percent: '6'
        tax_percent: $("#applyTotalTax").val()
    },
    methods: {
        addItem: function () {
            var newItem = $('#select22').select2('data')[0];
            if (newItem.id != '') {
                newItem.text = newItem.text.replace(/ *\([^)]*\) */g, "");
                var tableName  = $("#tableNo").val();
                var tableCheckVar = $("#tableCheckVar").val();
                
                if($.cookie("booking_id") != undefined && tableCheckVar == 0) {
                    currentCookieValue = $.cookie("booking_id");

                    var isAllowToAdd = true;
                    var numbers = currentCookieValue.split(',');
                    for(var i = 0; i < numbers.length; i++)
                    {
                        if(tableName == numbers[i] ) {
                            isAllowToAdd = false;
                            alert('Table booked');
                            return false;
                        }
                    }
                    newCookieValue = currentCookieValue+","+tableName;
                    $.cookie("booking_id", newCookieValue, { path: '/' });
                } else {
                    $.cookie("booking_id", tableName,{ path: '/' });
                }
                $("#tableCheckVar").val(1);

                newItem.qty = $('#qty0').val();
                var isNew = true;
                for (var i = 0; i < app.items.length; i++) {
                    if (app.items[i].id == newItem.id) {
                        isNew = false;
                        app.items[i].qty = parseInt(app.items[i].qty) + parseInt(newItem.qty);
                    }
                }
                if (isNew) {
                    app.items.push(newItem);
                }
                init_select2();
            }
            $('#select22').focus();
        },
        decreaseQuantity: function (index) {
            if (this.items[index].qty > 1) {
                this.items[index].qty = parseInt(this.items[index].qty) - 1;
            }
        },
        increaseQuantity: function (index) {
            this.items[index].qty = parseInt(this.items[index].qty) + 1;
        },
        removeItem: function (index) {
            this.items.splice(index, 1);
        },
        submitItems: function () {
            if (this.items.length > 0) {
                $("#indexSubmitId").attr("disabled", "disabled");
                $.ajax({
                    url: "submit.php",
                    type: 'POST',
                    data: {
                        items: JSON.stringify(this.items),
                        totalAmount: totalAmount,
                        tableNo: $('#tableNo').val(),
                        tax_percent: this.tax_percent,
                        discount_percent: this.discount_percent,
                        discount_remarks: this.discount_remarks,
                        total_amount_payable: this.total_amount_payable
                    },
                    success: function (response) {
                        if (response != 'error') {
                            var tableName = $('#tableNo').val();
                            currentCookieValue = $.cookie("booking_id");
                            var numbers = currentCookieValue.split(',');
                            var arr1 = [];
                            for(var i = 0; i < numbers.length; i++)
                            {
                                if(tableName != numbers[i] ) {
                                    arr1.push(numbers[i]);
                                }
                            }
                            $.cookie("booking_id", arr1, { path: '/' });
                            location.href = 'print.php?id=' + response;
                        }
                    }
                });
            } else {
                $('#select22').focus();
            }
        }
    },
    computed: {
        totalAmount() {
            totalAmount = this.items.reduce(function (totalAmount, item) {
                return totalAmount + (item.price * item.qty)
            }, 0);
            return totalAmount;
        },

        discount_amount() {
            return Math.round(this.totalAmount * this.discount_percent) / 100
        },

        GST() {
            return Math.round(this.totalAmount - this.discount_amount) * this.tax_percent / 100
        },

        total_amount_payable() {
            return Math.round((this.totalAmount - this.discount_amount) + this.GST);
        }
    }
});

  