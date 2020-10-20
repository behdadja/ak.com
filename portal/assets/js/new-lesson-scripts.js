$(document).ready(function(){
	$("#test").hide();
	$('#dep').on('change', function() {
		if ( this.value == '2' || this.value == '3' || this.value == '4')
		{
			$("#test").show();
		}
		else
		{
			$("#test").hide();
		}
	});
});

$(document).ready(function () {
	$('select[name="department"]').on('change', function () {
		var dpr = $(this).val();
		if (dpr) {
			$.ajax({
				url: 'dropdown/academy/' + dpr,
				type: "GET",
				dataType: "json",
				success: function (data) {
					$('select[name="stnd"]').empty();
					$('select[name="group"]').empty();
					$('select[name="cluster"]').empty();
					$('select[name="cluster"]').append('<option value=""> لطفا انتخاب کنید </option>');
					$.each(data, function (key, value) {
						$('select[name="cluster"]').append('<option value="' + value.cluster_id + '">' + value.cluster_name + '</option>');
					});
				}
			});
		} else {
			$('select[name="cluster"]').empty();
			$('select[name="group"]').empty();
			$('select[name="stnd"]').empty();
		}
	});


	$('select[name="cluster"]').on('change', function () {
		var clust = $(this).val();
		if (clust) {
			$.ajax({
				url: 'dropdown/cluster/' + clust,
				type: "GET",
				dataType: "json",
				success: function (data) {
					$('select[name="stnd"]').empty();
					$('select[name="group"]').empty();
					$('select[name="group"]').append('<option value=""> لطفا انتخاب کنید </option>');
					$.each(data, function (key, value) {
						$('select[name="group"]').append('<option value="' + value.group_id + '">' + value.group_name + '</option>');
					});
				}
			});
		} else {
			$('select[name="group"]').empty();
			$('select[name="stnd"]').empty();
		}
	});


	$('select[name="group"]').on('change', function () {
		var grp = $(this).val();
		if (grp) {
			$.ajax({
				url: 'dropdown/group/' + grp,
				type: "GET",
				dataType: "json",
				success: function (data) {
					$('select[name="stnd"]').empty();
					$('select[name="stnd"]').append('<option value=""> لطفا انتخاب کنید </option>');
					$.each(data, function (key, value) {
						$('select[name="stnd"]').append('<option value="' + value.standard_id + '">' + value.standard_name + '</option>');
					});
				}
			});
		} else {
			$('select[name="stnd"]').empty();
		}
	});
});

rescuefieldvalues(['lesson_name', 'lesson_description','lesson_own_code']);



var room = 1;
function education_fields() {

	room++;
	var objTo = document.getElementById('education_fields')
	var divtest = document.createElement("div");
	divtest.setAttribute("class", "removeclass"+room);
	var rdiv = 'removeclass'+room;
	divtest.innerHTML =
		'<div class="col-sm-1">' +
		'<div class="form-group">' +
		'<div class="input-group"> ' +
		'<div class="input-group-btn"> ' +
		'<button class="btn btn-danger" type="button" onclick="remove_education_fields('+ room +');"> <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ' +
		'</button>' +
		'</div>' +
		'</div>' +
		'</div>' +
		'</div>' +
		'<div class="col-sm-2">' +
		'<div class="form-group"> ' +
		'<input type="text" class="form-control" id="test_name" name="test_name[]" value="" placeholder="کتبی">' +
		'</div>' +
		'</div>' +
		'<div class="col-sm-3">' +
		'<div class="form-group"> ' +
		'<input type="text" class="form-control" id="range_score" name="range_score[]" value="" placeholder="">' +
		'</div>' +
		'</div>' +
		'<div class="col-sm-3">' +
		'<div class="form-group"> ' +
		'<input type="text" class="form-control" id="quota_score" name="quota_score[]" value="" placeholder="">' +
		'</div>' +
		'</div>' +
		'<div class="col-sm-3">' +
		'<div class="form-group">' +
		'<input type="text" class="form-control" id="percentage" name="percentage[]" value="" placeholder="">' +
		'</div>' +
		'</div>' +
		'</div>' +
		'</div>' +
		'<div class="clear"></div>';

	objTo.appendChild(divtest)
}
function remove_education_fields(rid) {
	$('.removeclass'+rid).remove();
	room--;
}
