$(document).ready(function () {
    
    dataTableServerSide()
    edit()
    create()
});

function validation(form) {
    var t = this
        formValidation('#merchant-form',
            {
                merchant_name   : { required: true },
                date_format     : { required: true },
                no_tlp          : { number: true },
                pos_code        : { maxlength : 10},
                rt        : { maxlength : 4},
                rw        : { maxlength : 4}
            },
            {},
            (form)=>{
                submitHandler(form)
            }
        );
        
}

function submitHandler(form) {
    $.post(
        "before_saving",
        {
            merchant_id     : $('input[name="merchant_id"]').val(),
            merchant_name   : $('input[name="merchant_name"]').val()
        }, 
        function (data) {
            if (data.res) {
                toastr['success'](data.message)
                form.submit()
            } else {
                toastr['warning'](data.message)
                
            }
        },"json"
        );
}

function create() {
    $('.btn-add-control').click(function(e) {
        e.preventDefault()
        let args = {
            title       : 'Menambahkan Wajib Pajak',
            url         : '/cms_bprd/merchant/create',
            ajaxParam   : {},
            btnAction   : {
                cssClass    : 'btn-primary action-btn',
                text        : 'Simpan',
                onPress       : function(e) {
                   $('#merchant-form').submit()
                }
            },
            doSomething    : function(e) {
                let modalDialog = $('#global-modal .modal-dialog')

                validation('#merchant-form')
            }
        }
        
        modal('open', args)
    })
}

function edit() {
   $('#merchant-list tbody').on('click', '.edit-control', function(e) {
        e.preventDefault()
        let id = $(this).attr('data-merchant-id')
        let args = {
            title       : 'Edit Wajib Pajak',
            url         : '/cms_bprd/merchant/edit',
            ajaxParam   : {merchant_id : id},
            btnAction   : {
                cssClass    : 'btn-primary action-btn',
                text        : 'Simpan',
                onPress       : function(e) {
                    $('#merchant-form').submit()
                }
            },
            doSomething    : function(e) {
                let modalDialog = $('#global-modal .modal-dialog')
                
                validation('#merchant-form')
            }
        }
        
        modal('open', args)
    })
}

function deleted() {
    $('#merchant-list tbody').on('click', '.delete-control', function(e) {
        e.preventDefault()
        let el = $(this)
        let id = el.attr('data-merchant-id')
        $.post(
        "before_delete",
        {
            merchant_id     : id
        },
        function (data) {
            if (data.res) {
                if (confirm('Apakah anda yakin ingin menghapus data?')) {
                    toastr['success'](data.message)
                    window.location.href = el.attr('href');
                }
            } else {
                toastr['warning'](data.message)
                return false
            }
        },"json"
        );
    })
}

function dataTableServerSide() {
    $('#merchant-list').DataTable({
        processing      : true,
        serverSide      : true,
        ajax: {
            "url": 'get_merchant_data',
            "type": "POST",
            'dataType' : 'json'
        },
        
        columnDefs: [
            {
                  
            }
        ]

    });

    edit()
    deleted()
}