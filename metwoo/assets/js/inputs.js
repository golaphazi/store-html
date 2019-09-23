(function ($, elementor) {
    "use strict";

	var MetForm = {

		init: function () {
			var widgets = {
                'mf-range.default': MetForm.RangeInput,
                'mf-date.default': MetForm.DateInput,
                'mf-time.default': MetForm.TimeInput,
                'mf-dropdown.default': MetForm.DropDownInput,
                'mf-multi-dropdown.default': MetForm.MultiSelectInput,
                'mf-rating.default': MetForm.Rating,
			};
			$.each(widgets, function (widget, callback) {
				elementor.hooks.addAction('frontend/element_ready/' + widget, callback);
			});
        },
        
		RangeInput: function ($scope) {

            var el = $scope.find('.mf-input-wrapper input[type="range"]'),
                min = el.attr('min'),
                max = el.attr('max');

                el.asRange(); 
        },

        DateInput: function ($scope) {
            var el = $scope.find('input[type="date"]');
            var minDateToday = el.attr('mfmindatetoday');
            var rangeDate = el.attr('mfrangedate');
            var dateFormat = el.attr('mf_date_format');
            var wrapper = $scope.find('.mf-input-wrapper');

            var config = {
                appendTo: wrapper.get(0),
                dateFormat: dateFormat,
            }

            if(minDateToday == 'yes') config.minDate = 'today';
            if(rangeDate == 'yes') config.mode = 'range';

            el.flatpickr(config);
        },

        TimeInput: function ($scope) {
            var el = $scope.find('input[type="time"]');
            var time24h = el.attr('mftime24h');
            var wrapper = $scope.find('.mf-input-wrapper');
            var config = {
                appendTo: wrapper.get(0),
                dateFormat: "h:i K",
                enableTime: true,
                noCalendar: true
            }

            if(time24h == 'yes'){
                config.dateFormat = 'H:i';
                config.time_24hr = true;
            }

            el.flatpickr(config);
        },

        DropDownInput: function ($scope) {
            var el = $scope.find('select.mf-input-dropdown');

            el.select2({
                dropdownParent: $scope.find('.mf-input-wrapper')
            });
        },

        MultiSelectInput: function( $scope ) {
            var el = $scope.find('select.mf-input-multiselect');
            el.select2({
                dropdownParent: $scope.find('.mf-input-wrapper')
            });
        },

        Rating: function($scope){
            var el = $scope.find('#mf-input-rating li');
            el.on('mouseover', function(){
                var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
               $(this).parent().children('li.star-li').each(function(e){
                  if (e < onStar) {
                    $(this).addClass('hover');
                  }
                  else {
                    $(this).removeClass('hover');
                  }
                });
                
              }).on('mouseout', function(){
                $(this).parent().children('li.star-li').each(function(e){
                  $(this).removeClass('hover');
                });
              });
              
              
              el.on('click', function(){
                var onStar = parseInt($(this).data('value'), 10);
                var stars = $(this).parent().children('li.star-li');
                
                for (let i = 0; i < stars.length; i++) {
                  $(stars[i]).removeClass('selected');
                }
                
                for (let i = 0; i < onStar; i++) {
                  $(stars[i]).addClass('selected');
                }
                
                var displayId = $(this).parents().find('input.mf-input-rating-hidden');
                displayId.val(onStar);
                
                var msg = "";
                if (onStar > 1) {
                    msg = "<strong>" + onStar + "</strong>";
                }
                else {
                    msg = "<strong>" + onStar + " </strong>";
                }
                
              });
        }
    };

	$(window).on('elementor/frontend/init', MetForm.init);
}(jQuery, window.elementorFrontend));