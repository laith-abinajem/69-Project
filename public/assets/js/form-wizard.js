$(function () {
	'use strict'
	$('#wizard1').steps({
		headerTag: 'h3',
		bodyTag: 'section',
		autoFocus: true,
		titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>'
	});
	$('#wizard2').steps({
		headerTag: 'h3',
		bodyTag: 'section',
		autoFocus: true,
		titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>',
		onStepChanging: function (event, currentIndex, newIndex) {
			if (currentIndex < newIndex) {
				// Step 1 form validation
				if (currentIndex === 0) {
					var bname = $('#brandname').parsley();
					var bimage = $('#brandimage').parsley();
					var bdescription = $('#branddescription').parsley();
					var blevel = $('#brandlevel').parsley();
					
					if (bname.isValid() && bdescription.isValid() && bimage.isValid() && blevel.isValid()) {
						return true;
					} else {
						bname.validate();
						bdescription.validate();
						bimage.validate();
						blevel.validate();
					}


				}
				// Always allow step back to the previous step even if the current step is not valid.
			} else {
				return true;
			}
		}
	});

	$('#wizardnew').steps({
		headerTag: 'h3',
		bodyTag: 'section',
		autoFocus: true,
		titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>',
		onStepChanging: function (event, currentIndex, newIndex) {
			if (currentIndex < newIndex) {
				// Step 1 form validation
				if (currentIndex === 0) {
					var bname = $('#brandname').parsley();
					var bimage = $('#brandimage').parsley();
					var bdescription = $('#branddescription').parsley();
					
					if (bname.isValid() && bdescription.isValid() && bimage.isValid()) {
						return true;
					} else {
						bname.validate();
						bdescription.validate();
						bimage.validate();
					}


				}
				// Always allow step back to the previous step even if the current step is not valid.
			} else {
				return true;
			}
		}
	});

	$('.dropify2').dropify({
		messages: {
			'default': 'Drag and drop a file here or click',
			'replace': 'Drag and drop or click to replace',
			'remove': 'Remove',
			'error': 'Ooops, something wrong appended.'
		},
		error: {
			'fileSize': 'The file size is too big (2M max).'
		}
	});


	$('#colorPicker').on('input', function () {
		$('#hex').val($(this).val());
		$('#selectedColor').text($(this).val());
	});

	$('#hex').on('input', function () {
		const hexValue = $(this).val();
		if (/^#[0-9A-F]{6}$/i.test(hexValue)) {
			$('#colorPicker').val(hexValue);
			$('#selectedColor').text(hexValue);
		}
	});

	$('#wizard3').steps({
		headerTag: 'h3',
		bodyTag: 'section',
		autoFocus: true,
		titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>',
		stepsOrientation: 1
	});
});