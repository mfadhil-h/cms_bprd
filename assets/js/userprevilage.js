$(document).ready(function() {
 	$('#user-previlage-list').dataTable()
 	create()
	edit()
    give_access()
    deleted()
})

function deleted() {
    $('#user-previlage-list tbody').on('click', '.delete-control', function(e) {
    	e.preventDefault()
        let el = $(this)
        let id = el.attr('data-up-id')
        $.post(
        "before_delete",
        {
            up_id     : id
        },
        function (data) {
            if (data.res) {
                if (confirm('Do you really want to delete this User Previlage?')) {
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

function create() {
   $('.btn-add-control').click(function(e) {
        e.preventDefault()
        let args = {
            title       : 'Create User Previlage',
            url         : '/cms_bprd/UserPrevilage/create',
            ajaxParam   : {},
            btnAction   : {
                cssClass    : 'btn-primary action-btn',
                text        : 'Save',
                onPress       : function(e) {
                   $('#user-previlage-form').submit()
                }
            },
            doSomething    : function(e) {
                let modalDialog = $('#global-modal .modal-dialog')

                validation('#user-previlage-form')
            }
        }
        
        modal('open', args)
    })
}

function give_access() {
    $('#user-previlage-list tbody').on('click', '.access-control', function(e) {
        e.preventDefault()
        let args = {
            title       : 'Give Access Module',
            url         : '/cms_bprd/UserPrevilage/give_access',
            ajaxParam   : {
                'up_id' : $(this).attr('data-up-id')
            },
            btnAction   : {
                cssClass    : 'btn-primary action-btn',
                text        : 'Save',
                onPress       : function(e) {
                   $('#user-previlage-form').submit()
                }
            },
            doSomething    : function(e) {
                let modalDialog = $('#global-modal .modal-dialog')

                modalDialog.addClass('modal-lg')
                $('#global-modal').on('hidden.bs.modal', function(e) {
                    modalDialog.removeClass('modal-lg')
                })
            }
        }
        
        modal('open', args)
    })
}

function edit() {
    $('#user-previlage-list tbody').on('click', '.edit-control', function(e) {
        e.preventDefault()
        
        let args = {
            title       : 'Edit User Previlage',
            url         : '/cms_bprd/UserPrevilage/edit',
            ajaxParam   : {
                'up_id' : $(this).attr('data-up-id')
            },
            btnAction   : {
                cssClass    : 'btn-primary action-btn',
                text        : 'Save',
                onPress       : function(e) {
                   $('#user-previlage-form').submit()
                }
            },
            doSomething    : function(e) {
                let modalDialog = $('#global-modal .modal-dialog')

                validation('#user-previlage-form')
            }
        }
        
        modal('open', args)
    })
}

function validation(form) {
    var t = this
    formValidation('#user-previlage-form',
        {
            up_level : { required : true },
            up_name  : { required : true }
        },
        {},
        (form)=>{
            submit_handler(form)
        }
    );
}

function submit_handler(form)
{
    $.post(
    "before_saving",
    {
        up_id          	: $('input[name="up_id"]').val(),
        up_name 		: $('input[name="up_name"]').val()
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