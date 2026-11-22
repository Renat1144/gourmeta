<script>
		jQuery(function() {
			jQuery('.hide_same').click(function (e) {
                e.preventDefault();

                jQuery(this).toggleClass('active');

                if (jQuery(this).hasClass('active'))
                {
                    jQuery(this).html('Показать одинаковые поля<span></span>');

                    props = {};

                    // обходим все свойства
                    jQuery('#comparisonTool .col .machine-details li').each(function() {
                        title = jQuery(this).find('h3').text();
                        value = jQuery(this).find('.value').text();

                        if (!props[title])
                            props[title] = {'same' : true, 'value' : value};
                        else if (props[title].value != value)
                            props[title].same = false;
                    });

                    // обходим еще раз все свойства и скрываем
                    jQuery('#comparisonTool .col .machine-details li').each(function() {
                        title = jQuery(this).find('h3').text();

                        if (props[title] && props[title].same)
                            jQuery(this).hide();
                    });
                }
                else
                {
                    jQuery(this).html('Скрыть одинаковые поля<span></span>');
                    jQuery('#comparisonTool .col .machine-details li').show();
                }
            });
		});
	</script>
