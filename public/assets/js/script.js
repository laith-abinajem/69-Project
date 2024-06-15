$(function() {
	
	/* sparkline_bar */
	$(".sparkline_bar").sparkline([2, 4, 3, 4, 5, 4,5,3,4], {
		type: 'bar',
		height:30,
		width:50,
		barWidth: 4,
		
		barSpacing: 2,
		colorMap: {
			'9': '#a1a1a1'
		},
		barColor: '#0bd02b'
	});
	/* sparkline_bar31 end */
	
	/* sparkline_bar31 */
	$(".sparkline_bar31").sparkline([2, 4, 3, 4, 5, 4,5,3,4], {
		type: 'bar',
		height:30,
		width:50,
		barWidth:4,
		barSpacing: 2,
		colorMap: {
			'9': '#a1a1a1'
		},
		barColor: '#fb5da9',
	});
	/* sparkline_bar31 end */
	
	
	/* p-scroll */
	if($('.setting-scroll').length){
		const ps12 = new PerfectScrollbar('.setting-scroll', {
			useBothWheelAxes:true,
			suppressScrollX:true,
		  });
	}


	$(document).ready(function(){
		$('#managePlanModal').on('show.bs.modal', function (e) {
			$('.manage-select2').select2({
				dropdownParent: $('#managePlanModal')
			});
		});
		$('#managePlanModal2').on('show.bs.modal', function (e) {
			$('.add-select2').select2({
				dropdownParent: $('#managePlanModal2')
			});
		});
		$('#managePlanModal3').on('show.bs.modal', function (e) {
			$('.edit-select').select2({
				dropdownParent: $('#managePlanModal3')
			});
		});

		$('#user_id').select2({
			placeholder: 'Choose one',
			searchInputPlaceholder: 'Search',
			 width: '100%'
		});
	})
	
	

});