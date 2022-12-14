$(document).ready(function() {
 	dataTableServerSide()
    create()
 	$('#btn-cancel').click(function(e) {
 		let el = $(this)
 		window.location.href = el.attr('href');
 	})
})

function submit_handler(form)
{
     $.post(
    "before_saving",
    {
        id          : $('input[name="id"]').val(),
        branch_name : $('input[name="branch_name"]').val()
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
    $('.btn-add').click(function(e) {
        e.preventDefault()
        let args = {
            title       : 'Menambahkan Otlet/Cabang',
            url         : '/cms_bprd/branch/create',
            ajaxParam   : {},
            btnAction   : {
                cssClass    : 'btn-primary action-btn',
                text        : 'Simpan',
                onPress       : function(e) {
                   $('#branch-form').submit()
                }
            },
            doSomething    : function(e) {
                let modalDialog = $('#global-modal .modal-dialog')

                validation('#branch-form')
            }
        }
        
        modal('open', args)
    })
}

function edit() {
   $('#branch-list tbody').on('click', '.edit-control', function(e) {
        e.preventDefault()
        let id = $(this).attr('data-id')
        let args = {
            title       : 'Edit Otlet/Cabang',
            url         : '/cms_bprd/branch/edit',
            ajaxParam   : {id : id},
            btnAction   : {
                cssClass    : 'btn-primary action-btn',
                text        : 'Simpan',
                onPress       : function(e) {
                    $('#branch-form').submit()
                }
            },
            doSomething    : function(e) {
                let modalDialog = $('#global-modal .modal-dialog')
                
                validation('#branch-form')
            }
        }
        
        modal('open', args)
    })
}

function validation(form) {
    var t = this
    formValidation('#branch-form',
        {
            branch_name     : { required: true },
            nopd            : { required: true },
            npwp            : { required: true },
            pos_code        : { number: true },
            no_tlp          : { number: true }
            //rekening_number : { required: true, number: true}
        },
        {},
        (form)=>{
            submit_handler(form)
        }
    );
}


function deleted() {
    $('#branch-list tbody').on('click', '.delete-control', function(e) {
        e.preventDefault()
        let el = $(this)
        let id = el.attr('data-branch-id')
        $.post(
        "before_delete",
        {
            id     : id
        },
        function (data) {
            if (data.res) {
                if (confirm('Apakah anda yakin ingin menghapus data ?')) {
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
    $('#branch-list').DataTable({
        processing      : true,
        serverSide      : true,
        ajax: {
            "url": 'get_data',
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