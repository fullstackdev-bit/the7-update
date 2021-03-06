<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the <div class="wf-container"> and all content after
 *
 * @package The7
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( presscore_is_content_visible() ): ?>

			</div><!-- .wf-container -->
		</div><!-- .wf-wrap -->





	<?php
	/**
	 * @since 6.8.1
	 */
	do_action( 'the7_after_content_container' );
	?>

	</div><!-- #main -->

	<?php
	if ( presscore_config()->get( 'template.footer.background.slideout_mode' ) ) {
		echo '</div>';
	}
	?>

<?php endif // presscore_is_content_visible ?>

	<?php do_action( 'presscore_after_main_container' ) ?>

	<a href="#" class="scroll-top"><span class="screen-reader-text"><?php esc_html_e( 'Go to Top', 'the7mk2' ) ?></span></a>

</div><!-- #page -->

<?php wp_footer() ?>

<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="pswp__bg"></div>
    <div class="pswp__scroll-wrap">
 
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>
 
        <div class="pswp__ui pswp__ui--hidden">
            <div class="pswp__top-bar">
                <div class="pswp__counter"></div>
                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                <button class="pswp__button pswp__button--share" title="Share"></button>
                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                      <div class="pswp__preloader__cut">
                        <div class="pswp__preloader__donut"></div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div> 
            </div>
            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>
            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>
            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>

jQuery(document).ready(function(){
	
	
	var future=new Date();
  	future.setDate(future.getDate());
  	// future.setDate(future.getDate()+30);
    jQuery( ".dateRange" ).datepicker({  minDate: future, dateFormat: 'yy-mm-dd' }); 
	
	//jQuery("#makePaymentForm").parsley();
	
	jQuery("#property_name").blur(function(){
		customFilterFunc();
	});
	
	jQuery(".custom_features").click(function(){ 
		
		customFilterFunc();
	});
	
	function customFilterFunc(){
		
		
		var property_name=jQuery("#property_name").val();
		property_name=property_name.toLowerCase();;
		if(property_name!=""){
			
			jQuery(".property_attribute").each(function(){
				var attr=jQuery(this).data("name");
				attr=attr.toLowerCase();
				
				console.log(property_name+"--"+attr);
				
				if(attr.indexOf(property_name)!=-1){
					jQuery(this).data("search",1);
					console.log("found");
				}else{
					jQuery(this).data("search",0);
					console.log("not found");
				}
			});
			
			
		}else{
			jQuery(".property_attribute").each(function(){
				jQuery(this).data("search",1);
			});
		}
	
		
		var attributes=[];
		jQuery(".custom_features").each(function(){
			if(jQuery(this). prop("checked") == true){
				attributes.push(jQuery(this).val());
			}
		});
		
		console.log(JSON.stringify(attributes));
		
		if(attributes.length==0){
			
			jQuery(".property_attribute").removeClass("hide");
			
			jQuery(".property_attribute").each(function(){
				if(jQuery(this).data("search")==0){
					
					jQuery(this).addClass('hide');
				
				}else{
					
					jQuery(this).removeClass('hide');
					console.log('good very');
				}
			});
			
		
		}else{
			
			 
					
					jQuery(".property_attribute").each(function(){
						
						console.log(jQuery(this).data("search"));
						
						if(jQuery(this).data("search")==1){
							
							
							
						
							var attr=jQuery(this).data("attributes");
							
							var fullFeature=attr.split(',');
							
							//console.log(fullFeature);
							
							var validatorChecker=0;
							var common=[];
							
							for(var tmp=0;tmp<attributes.length;tmp++){
								
								console.log("selected attribute :: "+attributes[tmp]);
								
								if(jQuery.inArray(attributes[tmp],fullFeature)==-1){
									validatorChecker++;
									console.log("Validator Checker"+validatorChecker);
									
								}
								
							}
							/*
							var common = jQuery.grep(fullFeature, function(element) {
								return jQuery.inArray(element, attributes ) !== -1;
							});*/
							
							if(validatorChecker!=0){
								
								jQuery(this).addClass('hide');  
							}else{
								jQuery(this).removeClass('hide');  
							}
							
						}else{
							jQuery(this).addClass('hide');  
							
						}
						
						   
						
						// if(attr.indexOf(val) == -1){
							// $(".property_attribute").addClass("hide");
						// }
						
					});
			
			
		}
	}
	
	jQuery('.cust_testimonials .carousel-indicators>li:first').addClass('active');
	jQuery('.cust_testimonials .carousel-inner>.item:first').addClass('active');
	
});
</script>
</body>
</html>