<script>
		jQuery(function() {
			//jQuery('#your-dispensers').prop('disabled', true);

			jQuery('.quote-form-selection .col input[type="checkbox"]').change(recordSelectedDispensers);

			recordSelectedDispensers();
		});

		function recordSelectedDispensers()
		{
			var text = [];
			jQuery('.quote-form-selection .col').each(function() {
				chb = jQuery(this).find('input[type="checkbox"]');
				if (chb.length == 0 || chb.prop('checked'))
				{
					text.push(jQuery(this).find('h3').text());
				}
			});

			jQuery('#your-dispensers').val(text.join('\n'));
		}
	</script>
