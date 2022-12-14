$(document).ready(function() {
 	$('#kecamatan-list').dataTable()

	$('#btn-cancel').click(function(e) {
		e.preventDefault()
		let el = $(this)
		window.location.href = el.attr('href');
 	})

 	$('#edit-control').click(function(e) {

 	})

 	function validation(message) {
		var t = this
		formValidation('#kecamatan_form',
			{
				kec_name: { required: true },
				suban_id: { required: true },
			},
			{},
			(form)=>{
				submitHandler(form, message)
			}
		);
	}

	function submitHandler(form, message) {
		let args = {
			kec_name : $('input[name="kec_name"]').val()
		}

		$.post({
			url		: 'before_saving',
			data 	: args,
			success : function (jsonData) {
				status = `${jsonData[11]}${jsonData[12]}${jsonData[13]}${jsonData[14]}`
				console.log(status)
				if (status == 'true') {
					toastr['success'](message)
					let delay = 1000;
					setTimeout(function() {
	 					form.submit()
					}, delay);
				} else {
					toastr['warning']('Nama kecamatan sudah tersedia')
				}
			},
			error 	: function (jsonData) {
				toastr['danger']('Terjadi kesalahan saat mengapus data')
			}
		})
	}

 	$('#btn-submit').click(function(e) {
 		let el 		= $(this)
 		let type 	= el.attr('btn-type')
 		let message = ''
 		if (type == 'create') {
 			message = 'Data kecamatan berhasil disimpan.'
 		} else {
 			message = 'Data kecamatan berhasil dirubah.'
 		}

 		validation(message)
 	})

 	$('.delete-control').click(function(e) {
 		e.preventDefault()
 		let el = $(this)
 			let args = {
 			kec_id : el.attr('data-kec-id')
 		}

 		$.post({
 			url		: 'before_delete',
 			data 	: args,
 			success : function(jsonData) {
 				status = `${jsonData[11]}${jsonData[12]}${jsonData[13]}${jsonData[14]}`
 				if (status == 'true') {
 					if (confirm('Yakin akan menghapus data ?')) {
 						toastr['success']('Data berhasil dihapus')
						let delay = 2000;
						setTimeout(function() {
		 					window.location.href = el.attr('href');
						}, delay)
			 		}
 				} else {
 					toastr['warning']('Data kecamatan tidak bisa dihapus.')
 				}
 			},

 			error	: function (jsonData) {
 				toastr['warning']('Terjadi keselahan saat menghapus data.')	
 			}
 		})

 	})
})