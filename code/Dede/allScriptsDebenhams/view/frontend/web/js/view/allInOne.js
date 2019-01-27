define([
    'jquery',
    'matchMedia',
    'jquery/ui'
], function($, mediaCheck) {
    'use strict';

//start customs.js
            				
	
    
                            //need to fix scroll of background when minicart is shown part 1
                          	$(document).ready(function() {
                                $(".showcart").click(function()
                                    {
									if ($(window).width() < 1200){
     								
                                    $('body').addClass("stop-move");
									$('header').addClass('shadow-of-morrdor');
									$('#maincontent').addClass('page-clone');
									
                                    }});
                          	});
				
//							$(document).ready(function(){
//								function gondor() {
//								$('.action.showcart.active').click(function(){
//									 if ($('header').hasClass('shadow-of-morrdor')){
//										 $('header').removeClass('shadow-of-morrdor');
//									 }
//								
//							});
//									
//									}
//								setTimeout(gondor, 7000);
//							});
				
				            //убрать тень мордора и stop move по клику на кнопку закрыть
//							$(document).ready(function(){
//								var onDiv = $('.action.showcart.active');
//								onDiv.live('click', function(){
//									console.log('WoW!');
//								    });
//							});
				
				
				
          	
							$(document).mouseup(function (e){ // событие клика по веб-документу
										var divWrap = $(".mage-dropdown-dialog"); // тут указываем элемент
										
										if (!divWrap.is(e.target) && divWrap.has(e.target).length === 0 )//если клик был не по нашему блоку и не по его дочерним элементам
											
										{ 
											$('header').removeClass('shadow-of-morrdor');//убираем тень Мордора! =)
											$('body').removeClass('stop-move'); //Убираем stop-move у body
											$('#maincontent').removeClass('page-clone');
										}
								
							});
							
											
                            ////////////accordion
				
							$(document).ready(function() {
							 //прикрепляем клик по заголовкам .btn-name
							$('.btn-name').on('click', f_acc);
							});

							function f_acc(){
							 
								$('.btn-name').not(this).removeClass('minus-icon');
								$(this).toggleClass('minus-icon');
							//скрываем все кроме того, что должны открыть
							  $('.btn-content').not($(this).next()).slideUp(300);
							// открываем или скрываем блок под заголовком, по которому кликнули
							  $(this).next().slideToggle(500);
								
							}
							
							
				
							
//							$(document).ready(function() {
//							 //прикрепляем клик по заголовкам .btn-name
//							$('.btn-name').on('click', add_class);
//							});
//
//							function add_class(){
//								$('.btn-name').not($(this)).removeClass('minus-icon'));
//								$(this).addClass('minus-icon');
//							} 
//				
						
							 //прикрепляем клик по заголовкам .btn-name.minus-icon
//							$('.btn-name.minus-icon').click(function(){
//									setTimeout(function(){
//										$(this).removeClass('minus-icon');
//									},100);
//								
//							});
							

				
				
				
				
//								var hiddenContent =	$('.btn-content');
//								var btnName = $('btn-name');
//								
//								if (hiddenContent.is(':none')){
//									btnName.addClass('plus-icon');
//									}
//								else{
//									btnName.removeClass('plus-icon');
//									}
								
							$(document).ready(function() {
								
								var emptyReviews = $('.product-reviews-summary.empty').length;
								var reviewsWrap = $('.product.info.detailed').addClass('empty-style');
								if (emptyReviews){
									reviewsWrap;
								}
							});	
								
							
											 
											 
				
				
				
                          	//need to fix scroll of background when minicart is shown part 2 setTimeout is neccessary
                          	$(document).ready(function() {
                          	    
                                function minicartBattle(){
                                $("#btn-minicart-close").click(function()
                                    {
                                   if ($('body').hasClass('stop-move')){
								
									$('body').removeClass('stop-move');
									$('header').removeClass('shadow-of-morrdor'); 
									   $('#maincontent').removeClass('page-clone');
									}
    	       						});
                                }
                                setTimeout(minicartBattle, 5000);
                          	});
				
							
				
				
				
                          
				            //need to add class orange to minicart part 1
    				        $(document).ready(function() {
                                    $("#product-addtocart-button").click(function(){
                                                $('.minicart-wrapper').addClass("orange");
                                                console.log('addClass_onClick');
                    
                                    }); 
                              });
				
                        //need to add class orange to minicart part 2 setTimeout is neccessary
                        $(document).ready(function() {
                            
                           
                              function orangeBattle() {     
                                var field = $('.counter-number').html();
                                var pattern = ("<!-- ko text: getCartParam('summary_count') -->0<!-- /ko -->");
                                
                                console.log(field);
                                
                                if (field !== pattern)
            					    {	
            						    $('.minicart-wrapper').addClass("orange");
            						    console.log('addClass_byTime');
            					    }
            				
            				    if (field === pattern)
            					    {	
            						    $('.minicart-wrapper').removeClass("orange");
            						    console.log('removeClass_byTime');
            					    }
            					    
                                
                             }
                        setTimeout(orangeBattle, 7000);
                        });
                        
                        
                        //need to add smooth scroll to product description like review
                        $(document).ready(function(){
                            $(".full-description-link").click(function() {
                                console.log('scrollDescription');
                                $('html, body').animate({
                                    scrollTop: $("#tab-label-product-description").offset().top -50
                                }, 300);
                            });
                        });
				
				
				        //need to add smooth scroll to review like in stock magento
						$(document).ready(function(){
                            $(".product-reviews-summary").click(function() {
                                console.log('scrollReview');
                                $('html, body').animate({
                                    scrollTop: $("#reviews1").offset().top -50
                                }, 300);
                            });
                        });
				
				
//                		$(document).ready(function(){
//						var div_name = document.getElementById("tab-label-reviews");
//						var	div_name_array = $.makeArray(div_name);
//						alert(div_name_array);
//						});
                
                ////
                if ($('#review-form').hasClass('notlogged')){
                    $('#review-form').addClass('toHide');
                }
                
                ////
                if ($(window).width() < 1024){	
					$('body').addClass('mobile-ver');
				}
					else{
						$('body').removeClass('mobile-ver');
					}
				////
			
				
				
				
				
				
//				ЛИПУЧЕЕ МЕНЮ!!!
				
/*			var navbar =  $('.block-collapsible-nav');  // navigation block
				var wrapper = $('.columns ');      // may be: navbar.parent();
				var hdr1 = $('header.page-header');
				
				$(window).scroll(function(){

					var nsc = $(document).scrollTop();
					var bp1 = $(wrapper)[0].getBoundingClientRect().top+hdr1.outerHeight();
								
					if(!navbar.hasClass('fix-block')){
						if (nsc>bp1) {
							navbar.addClass('fix-block');
							console.log(' if nsc '+nsc+ ' > '+'bp1'+bp1);
						}
					}
					
					if(navbar.hasClass('fix-block')){
						if (nsc<bp1) {
					 
							console.log(' else nsc '+nsc+ ' > '+'bp1'+bp1);
							navbar.removeClass('fix-block');
						}				
					} 

					var bp01 = $(navbar)[0].getBoundingClientRect().top+navbar.outerHeight();
					var bp02 = $(wrapper)[0].getBoundingClientRect().top+wrapper.outerHeight();
					
					if ( bp01 >=  bp02 ){
						console.log(' if bp01 '+bp01+ ' >= '+'bp02 '+bp02);
						navbar.addClass('scroll-end');
						
					}
					else{
						console.log(' else bp01 '+bp01+ ' >= '+'bp02 '+bp02);
						navbar.removeClass('scroll-end');
					}
					
				
//					var bposX = $(navbar).position().top + $('header.page-header').outerHeight()+20;
//					var contX = $(wrapper).offset().top + $(wrapper).outerHeight();
//					if(contX <= bposX){ 
//						$(navbar).addClass('scroll-end');
//					}else{
//						$(navbar).removeClass('scroll-end');
//					}
				}); */
				var forAddres = ('.account.customer-address-index.page-layout-2columns-left');
				if ($('.block-addresses-default').length)
				{
					$(forAddres).addClass('withAdd');
				}
				//////
				var buttonWL =('.thrith');
				var addItemWL =('.products-grid.wishlist');
				if ($(addItemWL).length){
					$(buttonWL).addClass('hide-button');
				}
				//////
				if ($('.orange').length){
					$('#wishlistButton').addClass('with-orange');
				}
				if ($('#wishlistButton').hasClass('with-orange')){
					$('.page-header').addClass('no-border-pls');
				}
				
					
				//// ?????? работает?
               /* var count = parseInt($('.counter').text());
                if (count !== 0){	
                $("#tab-label-reviews").addClass("active");}   
                     */
                /////

            
                
});
