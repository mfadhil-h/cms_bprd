$(document).ready(function() {
	$('#payment_autodebet').dataTable()

	var g_branch_id = ''
	get_branch()
	get_month()
	show_data()
	self_assessment()
	tax_payment()
	show_detail()
	download_recipt()
	show_history()

	$('.print-report').click(function(e) {
		window.print()
	})

	$('.close-report').click(function(){
	    window.close();
	});
	
})
function show_history() {
	$('#payment_autodebet tbody').on('click', '.history-control', function (e) {
		console.log('dasda')
		let el 			= $(this)
		let pa_id 		= el.attr('data-pa-id')
		let merchant_id	= el.attr('data-merchant-id')
		let branch_id   = el.attr('data-branch-id')

		let args = {
            title       : 'Histori Pembayaran',
            url         : 'history_payment',
            ajaxParam   : { pa_id : pa_id },
            btnAction   : {
                cssClass    : 'btn-primary action-btn',
                text        : 'Ok',
                onPress       : function(e) {
                    $('#note_form').submit()
                }
            },
            doSomething    : function(e) {
				$('#table-history-payment').dataTable()
                          
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

function download_recipt() {
	$('#payment_autodebet tbody').on('click', '.download-control', function (e) {
		let base_url = window.location.origin;

		let el 			= $(this)
		let pa_id 		= el.attr('data-pa-id')
		let merchant_id	= el.attr('data-merchant-id')
		let branch_id   = el.attr('data-branch-id')

		let url = `${base_url}/cms_bprd/payment_autodebet/download_file/${pa_id}/${merchant_id}/${branch_id}`
		window.open(url)
	})
}

function showDatatable(merchant_id, branch_id, month, year) {
	$('#payment_autodebet').dataTable().fnDestroy()
	$('#payment_autodebet').dataTable({
		processing      : true,
        serverSide      : true,
		ajax 			: {
			'url'		: 'get_data',
			'type'		: 'POST',
			'dataType'	: 'JSON',
			'data'	: {
				'merchant_id'	: merchant_id,
                'branch_id' 	: branch_id,
                'month'			: month,
                'year'			: year
			}
		},
		
		columnDefs	:[
			{
				targets : 4,
				render 	: (data, type, row) => {
					let pa_id 		= row['5']
					let merchant_id = row['6']
					let branch_id 	= row['7']
					
					let action = `<a data-month="${month}" data-year="${year}" data-pa-id="${pa_id}" data-merchant-id="${merchant_id}" data-branch-id="${branch_id}" class="show-detail-control ext-light mr-3 font-16" data-toggle="tooltip" title="Detail Pajak"><i class="fa fa-eye"></i></a>
					<a data-month="${month}" data-year="${year}" data-pa-id="${pa_id}" data-merchant-id="${merchant_id}" data-branch-id="${branch_id}" class="download-control ext-light mr-3 font-16" data-toggle="tooltip" title="Unduh Bukti Pembayaran"><i class="fa fa-download"></i></a>
					<a data-month="${month}" data-year="${year}" data-pa-id="${pa_id}" data-merchant-id="${merchant_id}" data-branch-id="${branch_id}" class="history-control ext-light mr-3 font-16" data-toggle="tooltip" title="Histori Pembayaran"><i class="fa fa-history"></i></a>`
					if (data != 2) {
						action = `<a data-month="${month}" data-year="${year}" data-pa-id="${pa_id}" data-merchant-id="${merchant_id}" data-branch-id="${branch_id}" class="selfassessment-control ext-light mr-3 font-16" data-toggle="tooltip" title="Revisi Nilai Pajak"><i class="fa fa-pencil"></i></a>
						<a></a>
						<a data-month="${month}" data-year="${year}" data-pa-id="${pa_id}" data-merchant-id="${merchant_id}" data-branch-id="${branch_id}" class="pay-control ext-light mr-3 font-16" data-toggle="tooltip" title="Baya Pajak"><i class="fa fa-money"></i></a>`
					}
					return action
				},
				createdCell: function (td, cellData, rowData, row, col) {
	               $(td).addClass('text-center');
	           }
			},
		],

		createdRow : function(row, data, dataIndex) {
			if (data[4] != 2) {
				$(row).addClass('danger');
			} else {
				$(row).addClass('success');
			}
		}
	})
}
function show_data() {
	$('#btn_get_data').click(function (event) {
		let year 		= $('select[name="year"]').val()
		let month 		= $('select[name="month"]').val()
		let merchant_id = $('select[name="merchant_id"]').val()
		let branch_id 	= $('select[name="branch_id"]').val()
		g_branch_id = branch_id
		
		if (year == '') {
			toastr['warning']('Pilih tahun untuk menanmpilkan data')
			return false
		}

		if (month == '') {
			toastr['warning']('Pilih bulan untuk menanmpilkan data')
			return false
		}

		showDatatable(merchant_id, branch_id, month, year)
	})
}

function get_month() {
	var month 		= new Date().getMonth() + 1;
    var monthname	= ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
    
    let year = new Date().getFullYear()

 
    $('#month').append('<option value="">--Pilih--</option>');
    
	
	$('#month').val('');
    
    $('#year').change(function(){
    	$('#month').empty();
    	
    	if( $('#year').val() == year ) {
        
	        for(var i=1;i<=month;i++){
	        	$('#month').append('<option value="'+i+'">'+monthname[i-1]+'</option>');
	        }

    	} else {
			for(var i=1;i<13;i++){
				$('#month').append('<option value="'+i+'">'+monthname[i-1]+'</option>');
			}
      	}
    });
}

function get_kode_bayar(merchant_id, branch_id, pa_id) {
	$.post(
		    "get_kode_bayar",
		    {
		        pa_id : pa_id
		    }, 
		    function (data) {
		   		if (!data.res) {
		       		toastr['warning'](data.message)
		       		return false
		       	} else {
		       		toastr['warning'](data.message)
		       	}
		    },"json"
	    );	 
}

function tax_payment() {
	$('#payment_autodebet tbody').on('click', '.pay-control', function(e) {
		let el = $(this)
		let merchant_id = el.attr('data-merchant-id')
		let branch_id 	= el.attr('data-branch-id')
		let pa_id		= el.attr('data-pa-id')
		let month 		= el.attr('data-month')
		let year 		= el.attr('data-year')
		
		console.log(g_branch_id)
		$.post(
		    "cek_reknumber",
		    {
		        merchant_id : merchant_id,
		        branch_id 	: branch_id
		    }, 
		    function (data) {
		    	
		       	if (!data.res) {
		       		toastr['warning'](data.message)
		       		return false
		       	} else {
		       		get_kode_bayar(merchant_id, branch_id, pa_id)
		       		showDatatable(merchant_id, g_branch_id, month, year)
		       	}	
		    },"json"
	    );	    
	})
}

function show_detail() {
	$('#payment_autodebet tbody').on('click', '.show-detail-control', function (e) {
		let el 			= $(this)
		let pa_id 		= el.attr('data-pa-id')
		let merchant_id	= el.attr('data-merchant-id')
		let branch_id   = el.attr('data-branch-id')

		let args = {
            title       : 'Detail',
            url         : 'show_detail',
            ajaxParam   : { pa_id : pa_id,
            				merchant_id : merchant_id,
            				branch_id : branch_id },
            btnAction   : {
                cssClass    : 'btn-primary action-btn',
                text        : 'Ok',
                onPress       : function(e) {
                    $('#note_form').submit()
                }
            },
            doSomething    : function(e) {
                let modalDialog = $('#global-modal .modal-dialog')      
            }
        }
        
        modal('open', args)
	})
}
function self_assessment() {
	$('#payment_autodebet tbody').on('click', '.selfassessment-control', function(e) {
		let el 			= $(this)
		let pa_id 		= el.attr('data-pa-id')
		let merchant_id	= el.attr('data-merchant-id')
		let branch_id   = el.attr('data-branch-id')

		let args = {
            title       : 'Revisi Nilai Pajak',
            url         : '/cms_bprd/payment_autodebet/self_assessment',
            ajaxParam   : { pa_id : pa_id,
            				merchant_id : merchant_id,
            				branch_id : branch_id },
            btnAction   : {
                cssClass    : 'btn-primary action-btn',
                text        : 'Simpan',
                onPress       : function(e) {
                    $('#note_form').submit()
                }
            },
            doSomething    : function(e) {
                let modalDialog = $('#global-modal .modal-dialog')

				modalDialog.addClass('modal-lg')
				$('#global-modal').on('hidden.bs.modal', function(e) {
				  modalDialog.removeClass('modal-lg')
				})

				taxkeyup()
			 	taxkeyp()
			 	datePicker()
			 	get_tax_value()
			 	
			 	let tr = $('#table-self-assetment tr:last td:last-child');
			 	tr.append('<a class="delete-control font-16" data-toggle="tooltip" title="Delete Data"><i class="fa fa-trash"></i></a>')
			 	deleteNote()
                add_axisting_data()
                add_other_data()

                let table 		= $('#table-self-assetment')
				let tr1 		= table.find('tr')
				let count 		= tr1.length - 1
				$('input[name="count"]').val(count)
		 		validation_note()
                
            }
        }
        
        modal('open', args)
	})
}


function validation_note() {
	var t = this
	let form = '#note_form'
	formValidation(form,
		{
			
		},
		{},
		(form)=>{
			submitHandler_note(form)
		}
	);
}

function submitHandler_note(form) {
		
	let table 		= $('#table-self-assetment')
	let tr 			= table.find('tbody tr').length
	let date 		= null
	let billNo 		= null
	let tax			= null
	let note 		= null

	if (tr == 0) {
		toastr['warning']('Silahkan isi data untuk menyimpan data')
		return false
	}

	for (var i = 0; i < tr; i++) {
		date 			= $(`input[name="date_transaction_${i}"`).val()
		billNo 			= $(`input[name="bill_number_${i}"`).val()
		billNoSelect 	= $(`select[name="bill_number_${i}"`).val()
		tax 			= $(`input[name="adjustment_value_${i}"`).val()
		note 			= $(`textarea[name="note_${i}"`).val()
		
		if (date == '') {
			toastr['warning'](`Data Tanggal #${i+1} is required`)
			return false
		}

		if (billNo == '') {
			toastr['warning'](`Bill Number #${i+1} is required`)
			return false
		}

		if (billNoSelect == '') {
			toastr['warning'](`Bill Number #${i+1} is required`)
			return false
		}

		if (tax == '') {
			toastr['warning'](`Nilai Pajak #${i+1} is required`)
			return false
		}

		if (note == '') {
			toastr['warning'](`Keterangan #${i+1} is required`)
			return false
		}
	}

	form.submit()
}
function get_branch() {
	$("#merchant_id").change(function(event){
	    $.post(
	        "/cms_bprd/report/branch",
                {
                    'merchant_id': $('#merchant_id').val(),
                }, function (data) {
                  $('#branch_id').find('option').remove();
                  $('#branch_id').append('<option value="ALL">--Semua Otlet--</option>');

                  for(var i=0;i<data.length;i++){
                      $('#branch_id').append('<option value="'+data[i]['branch_id']+'">'+data[i]['branch_name']+'</option>');
                  }
	        }, "json"
	    );
	});

	$('#tax').keypress(function(event) {
	    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
	    	event.preventDefault();
	    }
	});
}

function add_other_data() {
	$('.btn-add').click(function() {
		let merchantId 	= $('input[name="merchant_id"]').val()
		let branchId 	= $('input[name="branch_id"]').val()
		let month 		= $('input[name="month"]').val()
		let year 		= $('input[name="year"]').val()
		let table 		= $('#table-self-assetment')
		let tr 			= table.find('tr')
		let count 		= tr.length - 1
		$( "a" ).remove( ".delete-control" );
		let res = `<tr>
                        <td><div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" class="form-control date-picker" name="date_${count}" id="date_${count}" autocomplete="off">
                            <input type="hidden" name="date_transaction_${count}" id="date_transaction_${count}">
                        </div></td>
                        <td><input type="text" class="form-control" name="bill_number_${count}"></td>
                       	<td>
                       		<input type="text" disabled class=" ppnform-control tax text-right" name="ppn1_${count}" id="ppn1_${count}" value="0">
                       		<input type="hidden" class=" ppnform-control tax text-right" name="ppn_${count}" id="ppn_${count}" value="0">
                       	</td>
                        <td><input type="text" class="form-control tax text-right" name="adjustment_value_${count}" id="adjustment_value_${count}">
                        	<input type="hidden" name="merchant_id_${count}" id="merchant_id_${count}" value="${merchantId}">
                            <input type="hidden" name="branch_id_${count}" id="branch_id_${count}" value="${branchId}">
                            <input type="hidden" name="year_${count}" id="year_${count}" value="${year}">
                            <input type="hidden" name="month_${count}" id="month_${count}" value="${month}">
                            <input type="hidden" name="count" id="count" value="">
                            <input type="hidden" name="id_${count}" value="data_new">
                        </td>
                        <td><textarea name="note_${count}" class="form-control" id="note_${count}" class="col-sm-12"></textarea></td>
                    	<td class="text-center"><a class="delete-control font-16" data-toggle="tooltip" title="Delete Data"><i class="fa fa-trash"></i></a></td>
                    </tr>`
		table.find('tbody').append(res)
		$('input[name="count"]').val(tr.length)

		datePicker()
		get_tax_value()
		taxkeyup()
 		taxkeyp()
 		deleteNote()
	})
}

function add_axisting_data()
{
	$('.btn-add-axisting-data').click(function() {
		let merchantId 	= $('input[name="merchant_id"]').val()
		let branchId 	= $('input[name="branch_id"]').val()
		let month 		= $('input[name="month"]').val()
		let year 		= $('input[name="year"]').val()
		let table 		= $('#table-self-assetment')
		let tr 			= table.find('tr')
		let count 		= tr.length - 1
		$( "a" ).remove( ".delete-control" );
		let res = `<tr>
                        <td><div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" class="form-control date-picker data-date" name="date_${count}" id="date_${count}" autocomplete="off">
                            <input type="hidden" name="date_transaction_${count}" id="date_transaction_${count}">
                        </div></td>
                        <td>
                        	<select name="bill_number_${count}" id="bill_number_${count}" class="bill_number select select-picker form-control" data-live-search="true">
                        	<option value="">--Pilih--</option>
                        	</select>
                        </td>
                 		<td>
	                 		<input type="text" disabled class="ppn form-control tax text-right" name="ppn1_${count}" id="ppn1_${count}">
	                 		<input type="hidden" class="form-control tax text-right" name="ppn_${count}" id="ppn_${count}">
                 		</td>
                        <td><input type="text" class="form-control tax text-right" name="adjustment_value_${count}" id="adjustment_value_${count}">
                        	<input type="hidden" name="merchant_id_${count}" id="merchant_id_${count}" value="${merchantId}">
                            <input type="hidden" name="branch_id_${count}" id="branch_id_${count}" value="${branchId}">
                            <input type="hidden" name="year_${count}" id="year_${count}" value="${year}">
                            <input type="hidden" name="month_${count}" id="month_${count}" value="${month}">
                            <input type="hidden" name="count" id="count" value="">
                             <input type="hidden" name="id_${count}" value="data_new">
                        </td>
                        <td><textarea name="note_${count}" class="form-control" id="note_${count}" class="col-sm-12"></textarea></td>
                    	<td class="text-center"><a class="delete-control font-16" data-toggle="tooltip" title="Delete Data"><i class="fa fa-trash"></i></a></td>
                    </tr>`
		table.find('tbody').append(res)
		$('input[name="count"]').val(tr.length)

		datePicker()
		get_tax_value()
		taxkeyup()
 		taxkeyp()
 		deleteNote()
	})
}

function get_tax_value() {
	$('.bill_number').change(function(e){
		let bill_no = $(this).val()
		let month 		= $('input[name="month"]').val()
		let year 		= $('input[name="year"]').val()

		let name = $(this).attr('name')
		name = name.replace('bill_number', '')
		let element = `#ppn1${name}`
		let element2 = `#ppn${name}`
		$.post(
    		"/cms_bprd/note/get_tax_value",
            {
                'bill_no': bill_no,
                'month'	: month,
                'year' : year
            }, function (data) {
            $(element).val(data.tax) 
            $(element2).val(data.tax)             	
             
        },"json"
      	);
	})
}
function datePicker () {
	$('.date-picker').each(function () {
		$(this).datepicker({
	        format 				: 'd MM yyyy',
	        todayBtn 			: 'linked',
	        keyboardNavigation	: false,
	        forceParse			: false,
	        calendarWeeks		: true,
	        autoclose			: true
		}).on('changeDate', function(e){
			$(this).parent('.input-group').find('input[type="hidden"]').val(e.format('yyyy-mm-dd'))
			let merchantId = $('input[name="merchant_id"]').val()
			let branchId = $('input[name="branch_id"]').val()
			let date = e.format('yyyy-mm-dd')
			let name = $(this).attr('name')
			
			name = name.replace('date', '')
			var SITE_URL = '<?php echo SITE_URL?>';
			let element = `#bill_number${name}`
			$.post(
        		"/cms_bprd/note/getBillNo",
                {
                    'merchant_id': merchantId,
                    'branch_id' : branchId,
                    'date': date,
                }, function (data) {	                	
                  $(element).find('option').remove();
                  console.log(data)
                  $(element).append('<option value="">--Pilih--</option>')
                  for(var i=0;i<data.length;i++){
                      $(element).append('<option value="'+data[i]+'">'+data[i]+'</option>');
                  }
	        },"json"
	      	);
		})
	})
}

function taxkeyp() {
	$('.tax').keypress(function(event) {
      	if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        	event.preventDefault();
      	}
    })
}

function taxkeyup() {
    $('.tax').keyup(function(event) {
        if(event.which >= 37 && event.which <= 40){

        }else{
          
          $(this).val(function(index, value) {
            return value
            .replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            ;
          });
        }           
  	})
}

function deleteNote () {
	$('.delete-control').click(function() {
		let id = $(this).parent().attr('data-note-id')
		let year = $('input[name="year"]').val()
		let month = $('input[name="month"]').val()
		let merchantid = $('input[name="merchant_id"]').val()
		let branchid = $('input[name="branch_id"]').val()

		if (typeof id === 'undefined') {
				let table 		= $('#table-self-assetment')
				let lastTr		= $('#table-self-assetment tr:last')
				let element 	= '<a class="delete-control font-16" data-toggle="tooltip" title="Delete Data"><i class="fa fa-trash"></i></a>'
				lastTr.remove()
				let lastTd 		= $('#table-self-assetment tbody tr:last td:last-child');
				lastTd.append(element)
		} else {
			if (confirm('Do you really want to delete this record?')) {
	 			$.post(
		    		"/cms_bprd/note/delete",
		            {
		                'id'			: id,
		                'year'			: year,
		               	'month' 		: month,
		               	'merchant_id'	: merchantid,
		               	'branch_id'		: branchid
		            }, function (data) {	                	
		               	toastr['success']['Note adjustment has been deleted']
		               	let table 		= $('#table-self-assetment')
						let lastTr		= $('#table-self-assetment tr:last')
						let element 	= '<a class="delete-control font-16" data-toggle="tooltip" title="Delete Data"><i class="fa fa-trash"></i></a>'
						lastTr.remove()
						let lastTd 		= $('#table-self-assetment tbody tr:last td:last-child');
						lastTd.append(element)
		        },"json"
		      	);				
			}
		}
		deleteNote()
	})
}