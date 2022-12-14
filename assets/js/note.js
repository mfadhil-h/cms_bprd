$(document).ready(function() {
	
	taxkeyup()
 	taxkeyp()
 	datePicker()
 	
 	let tr = $('#note-list tr:last td:last-child');
 	tr.append('<a class="delete-control font-16" data-toggle="tooltip" title="Delete Data"><i class="fa fa-trash"></i></a>')
 	deleteNote()
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
	                  for(var i=0;i<data.length;i++){
	                      $(element).append('<option value="'+data[i]+'">'+data[i]+'</option>');
	                  }
		        },"json"
		      	);
			})
		})
	}
	
	$('.btn-submit').click(function(e) {
		let table 		= $('#note-list')
		let tr 			= table.find('tr')
		let count 		= tr.length - 1
		$('input[name="count"]').val(count)
 		validation()
 	})

	$('.btn-add-axisting-data').click(function() {
		let merchantId 	= $('input[name="merchant_id"]').val()
		let branchId 	= $('input[name="branch_id"]').val()
		let month 		= $('input[name="month"]').val()
		let year 		= $('input[name="year"]').val()
		let table 		= $('#note-list')
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
                        	<select name="bill_number_${count}" id="bill_number_${count}" class="select select-picker form-control" data-live-search="true">
                        	<option value="">--Choose--</option>
                        	</select>
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
		taxkeyup()
 		taxkeyp()
 		deleteNote()
	})

	$('.btn-add').click(function() {
		let merchantId 	= $('input[name="merchant_id"]').val()
		let branchId 	= $('input[name="branch_id"]').val()
		let month 		= $('input[name="month"]').val()
		let year 		= $('input[name="year"]').val()
		let table 		= $('#note-list')
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
		taxkeyup()
 		taxkeyp()
 		deleteNote()
	})

	function validation() {
		var t = this
		let form = '#note_form'
		formValidation(form,
			{
				
			},
			{},
			(form)=>{
				submitHandler(form)
			}
		);
	}

	$('.print-report').click(function(e) {
		window.print()
	})

	$('.close-report').click(function(){
	    window.close();
	});

	window.onbeforeunload = function(e) {
        e.preventDefault();
    }
    
	function submitHandler(form) {
		
		let table 		= $('#note-list')
		let tr 			= table.find('tbody tr').length
		let date 	= null
		let billNo 	= null
		let tax		= null
		let note 	= null

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
})

function deleteNote () {
	$('.delete-control').click(function() {
		let id = $(this).parent().attr('data-note-id')
		if (typeof id === 'undefined') {
				let table 		= $('#note-list')
				let lastTr		= $('#note-list tr:last')
				let element 	= '<a class="delete-control font-16" data-toggle="tooltip" title="Delete Data"><i class="fa fa-trash"></i></a>'
				lastTr.remove()
				let lastTd 		= $('#note-list tbody tr:last td:last-child');
				lastTd.append(element)
		} else {
			if (confirm('Do you really want to delete this record?')) {
	 			$.post(
		    		"/cms_bprd/note/delete",
		            {
		                'id': id
		            }, function (data) {	                	
		               	toastr['success']['Note adjustment has been deleted']
		               	let table 		= $('#note-list')
						let lastTr		= $('#note-list tr:last')
						let element 	= '<a class="delete-control font-16" data-toggle="tooltip" title="Delete Data"><i class="fa fa-trash"></i></a>'
						lastTr.remove()
						let lastTd 		= $('#note-list tbody tr:last td:last-child');
						lastTd.append(element)
		        },"json"
		      	);				
			}
		}
		deleteNote()
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
          // format number
          $(this).val(function(index, value) {
            return value
            .replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            ;
          });
        }           
  	})
}