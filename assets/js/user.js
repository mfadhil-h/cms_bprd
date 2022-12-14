$(document).ready(function() {
 	$('#user-list').dataTable()
    create()
    edit()
    deleted()
})

function select_branch(){
    $("#merchant_id").change(function(event){
        $.post(
            "/cms_bprd/report/branch",
                    {
                        'merchant_id': $('#merchant_id').val(),
                    }, function (data) {
                      
                      $('#branch_id').find('option').remove();
                      $('#branch_id').append('<option value="">--Choose--</option>');
                    
                      for(var i=0;i<data.length;i++){
                          $('#branch_id').append('<option value="'+data[i]['branch_id']+'">'+data[i]['branch_name']+'</option>');
                      }
            }, "json"
          );
    });
}

function previlage_level() {
    $('#up_id').change(function(e){
        let el = $('#up_id option:selected')
        level = el.attr("data-level")

        $('input[name="level"]').val(level)

        if (level == 3) {
            $('.suban').slideDown()
            $('.merchant').slideUp()
            $('.branch').slideUp()
        } else if (level == 4) {
            $('.merchant').slideDown()
            $('.branch').slideDown()
            $('.suban').slideUp()
        } else if (level == 5 ) {
            $('.merchant').slideDown()
            $('.branch').slideUp()
            $('.suban').slideUp()
        } else if(level == 6) {
            $('.merchant').slideDown()
            $('.branch').slideDown()
            $('.suban').slideUp()
        } else {
            $('.merchant').slideUp()
            $('.branch').slideUp()
            $('.suban').slideUp()
        }
    })
}

function create() {
   $('.btn-add-control').click(function(e) {
        e.preventDefault()
        let args = {
            title       : 'Create User',
            url         : '/cms_bprd/user/create',
            ajaxParam   : {},
            btnAction   : {
                cssClass    : 'btn-primary action-btn',
                text        : 'Save',
                onPress       : function(e) {
                   $('#user-form').submit()
                }
            },
            doSomething    : function(e) {
                let modalDialog = $('#global-modal .modal-dialog')

                $('.merchant').slideUp()
                $('.branch').slideUp()
                $('.suban').slideUp()
                select_branch()
                previlage_level()
                validation('#user-form')
            }
        }
        
        modal('open', args)
    })
}


function edit() {
    $('#user-list tbody').on('click', '.edit-control', function(e) {
        e.preventDefault()
        let args = {
            title       : 'Edit User Previlage',
            url         : '/cms_bprd/user/edit',
            ajaxParam   : {
                'id' : $(this).attr('data-id')
            },
            btnAction   : {
                cssClass    : 'btn-primary action-btn',
                text        : 'Save',
                onPress       : function(e) {
                   $('#user-form').submit()
                }
            },
            doSomething    : function(e) {
                let modalDialog = $('#global-modal .modal-dialog')
                let level = $('input[name="level"]').val()
                if (level == 3) {
                    $('.suban').slideDown()
                    $('.merchant').slideUp()
                    $('.branch').slideUp()
                } else if (level == 4) {
                    $('.merchant').slideDown()
                    $('.branch').slideDown()
                    $('.suban').slideUp()
                } else if (level == 5 ) {
                    $('.merchant').slideDown()
                    $('.branch').slideUp()
                    $('.suban').slideUp()
                } else if(level == 6) {
                    $('.merchant').slideDown()
                    $('.branch').slideDown()
                    $('.suban').slideUp()
                } else {
                    $('.merchant').slideUp()
                    $('.branch').slideUp()
                    $('.suban').slideUp()
                }

                previlage_level()
                select_branch()
                validation('#user-form')
            }
        }
        
        modal('open', args)
    })
}

function validation(form) {
    var t = this
    formValidation('#user-form',
        {
            username            : { required : true },
            password            : { required : true },
            password_confirm    : { required : true },
            up_id               : { required : true }
        },
        {},
        (form)=>{
            submit_handler(form)
        }
    );
}

function submit_handler(form)
{

    let pass = $('input[name="password"]').val()
    let passConfirm = $('input[name="password_confirm"]').val()
    let level = $('#up_id option:selected').attr('data-level')
    let merchant = $('select[name="merchant_id"]').val()
    let suban = $('select[name="suban_id"]').val()
    let branch = $('select[name="branch_id"]').val()

    if (pass != passConfirm) {
        toastr['warning']('Password and Confirm Password must be match !')
        return false
    }

   
    if (level == 3) {
        if (suban === '') {
            console.log(suban)
            toastr['warning']('suban is required !')
            return false
        }
    } else if (level == 4) {
        if (merchant === '' || branch === '') {
            toastr['warning']('merchant and branch is required !')
            return false
        }
    } else if (level == 5 ) {
       if (merchant === '') {
            toastr['warning']('merchant is required !')
            return false
        }
    } else if(level == 6) {
       if (merchant === '' || branch === '') {
            toastr['warning']('merchant and branch is required !')
            return false
        }
    }

   $.post(
        "/cms_bprd/user/before_saving",
        {
            username  : $('input[name="username"]').val(),
            id        : $('input[name="id"]').val()
        }, 
        function (data) {
            if (data.res) {
                toastr['success'](data.message)
                form.submit()
            } else {
                toastr['warning'](data.message)
                return false
            }
        },"json"
        );
}

function deleted() {
    $('#user-list tbody').on('click', '.delete-control', function(e) {
        e.preventDefault()
        let el = $(this)
        let id = el.attr('data-id')
        if (confirm('Do you really want to delete this User?')) {
            toastr['success']('Record has been successfully deleted')
            window.location.href = el.attr('href');
        }
    })
}   