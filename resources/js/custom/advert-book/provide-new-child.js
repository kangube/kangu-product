$(document).ready(function() {
	$('.advert-book-add-child-button').on("click", function() {
		$('.form-select-children-container > .number-children-container').append('<div class="child-container"><div class="child-container-input-field"><input type="text" class="child-name" name="advert-book-child-name[]" placeholder="Voor- en achternaam van jouw kind" required></div><div class="child-container-input-field"><select class="child-age" name="advert-book-child-age[]" required><option value="">Leeftijd van jouw kind</option><option value="3">3 jaar oud</option><option value="4">4 jaar oud</option><option value="5">5 jaar oud</option><option value="6">6 jaar oud</option><option value="7">7 jaar oud</option><option value="8">8 jaar oud</option><option value="9">9 jaar oud</option><option value="10">10 jaar oud</option><option value="11">11 jaar oud</option><option value="12">12 jaar oud</option></select></div><div class="child-container-input-field"><select class="advert-school child-school" name="advert-book-child-school[]" required></select></div><div class="child-container-input-field"><input type="text" class="child-class" name="advert-book-child-class[]" placeholder="Klasnummer van jouw kind" required></div><div class="child-container-input-field"><a class="advert-book-save-child-button">Toevoegen</a></div></div>');
		var closest_advert_school_select = $(this).prev().children('.child-container').last().find('.advert-school');
		closest_advert_school_select.append('<option value="" selected="selected">Basisschool van jouw kind</option>');
		
		$.getJSON('availability-schools.php', function(data) {
			$.each(data, function(key, val) {
				var school_name = "";
				school_name = val["school_name"].replace(/ /g, '&#32;');
			    closest_advert_school_select.append('<option value='+school_name+'>'+val["school_name"]+'</option>');
			});
		});
	});

	$('.advert-book-save-child-button').on("click", function (e) {
		e.preventDefault();

		current_child_parent = $(this).parent().parent().parent().find('.child-parent-id').val();
		current_child_name = $(this).parent().parent().find('.child-name').val();
		current_child_age = $(this).parent().parent().find('.child-age').val();
		current_child_school = $(this).parent().parent().find('.child-school').val();
		current_child_class = $(this).parent().parent().find('.child-class').val();

		if (current_child_parent.length > 0 && current_child_name.length > 0 && current_child_age.length > 0 && current_child_school.length > 0 && current_child_class.length > 0) {

			alert(current_child_parent);
		
			$.ajax({
				type: 'post',
				dataType: 'html',
				url: '../php-assets/class.provide-child.php',
				data: {childParent:current_child_parent, childName:current_child_name, childAge:current_child_age, childSchool:current_child_school, childClass:current_child_class},
				cache: false,
				success: function(data) {
					alert(data);
					$(this).parent('.child-container-input-field').parent().hide();
					//$('.provided-children-container').append('select-child-container');
				},
				error: function(){
			       alert('something failed!');
			    }
			});
		}
		else {
			$(this).parent().parent().parent().find('.child-container-error').css('display', 'block');
			$(this).parent().parent().parent().find('.child-container-error').html('Alle velden dienen verplicht ingevuld te worden.');
		}
	});
});