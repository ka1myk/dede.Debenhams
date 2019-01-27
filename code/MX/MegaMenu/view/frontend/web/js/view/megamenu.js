define([
    'jquery',
    'matchMedia',
    'jquery/ui'
], function($, mediaCheck) {
    'use strict';

    $.widget('mx.megaMenu', {
        _create: function() {
            this.init();
            this.bind();
        },

        init: function() {
            var self = this;

            if (!$('html').hasClass('mx-megamenu-init')) {
                
                $('html').addClass('mx-megamenu-init');
                
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
							 
								
								
								 
								
							//скрываем все кроме того, что должны открыть
							if ($(window).width() < 740){	
								$('.btn-name').not(this).removeClass('minus-icon');
								$(this).toggleClass('minus-icon');	
							    $('.btn-content').not($(this).next()).slideUp(300);
							    $(this).next().slideToggle(500);
								}
							 else {
								$('.btn-content').not($(this).next()).stop(true,true) ;
								$(this).next().stop(true,true);
								}
								}
							// открываем или скрываем блок под заголовком, по которому кликнули
									
							 
							
							 
							
				
						
								
							$(document).ready(function() {
								var noEmptRev = $('.action.view span').length;
								
								var contA = $('.action.view span').length;
								
								
								if (contA === 0 , noEmptRev === 0){
									$('.product.info.detailed').addClass('empty-style');
								} 
							});	
								
								
							$(document).ready(function() {
								
								var reviewsCount = $('#tab-label-reviews-title').html();
								
								$('#reviews1').html(reviewsCount);
								
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
                        
                        
                        //need to add smooth scroll of product description like review
                        $(document).ready(function(){
                            $(".full-description-link").click(function() {
                                console.log('scroll');
                                $('html, body').animate({
                                    scrollTop: $("#tab-label-product-description").offset().top
                                }, 200);
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

            
                
                //stop custom.js
                

                this.element.data('mage-menu', 1); // Add mageMenu attribute to fix breadcrumbs rendering on product page

                $(document).on('click', '.action.nav-toggle', function () {
                    if ($('html').hasClass('nav-open')) {
                        $('html').removeClass('nav-open');

                        self.element.find('.level-top').removeClass('current');
                        self.element.find('.mx-megamenu__item').removeClass('current');

                        setTimeout(function () {
                            $('html').removeClass('nav-before-open');
                            
                        }, 300);
                    } else {
                        $('html').addClass('nav-before-open');
                        
                

                        setTimeout(function () {
                            $('html').addClass('nav-open');
                        }, 42);
                    }
                });
            }

            // Add class for nav-anchor where the link has href
            this.element.find('.mx-megamenu__item .mx-megamenu__link').each(function(i, item) {
                if (self._hasSubmenu($(item))) {
                    $(item).addClass('has-submenu');
                }
            });
        },

        bind: function() {
            var self = this;

            mediaCheck({
                media: '(min-width: 1024px)',

                /**
                 * Switch to Desktop Version.
                 */
                entry: function () {
                    self.element.find('.level-top').hover(function() {
                        self.element.find('.level-top').removeClass('current');
                        $(this).addClass('current');
                        $('.page-wrapper').addClass('dark-back');
                    }, function() {
                        $(this).removeClass('current');
                        $('.page-wrapper').removeClass('dark-back');
                    });

                    /**
                     * New functionality - toggle
                     */
                    self.element.find('.level1').find('.nav-anchor').each(function(i, el) {
                        if ($(el).hasClass('hide')) {
                            $(el).next('.mx-megamenu__submenu').hide();
                        }

                        if ($(el).hasClass('toggle')) {
                            $(el).next('.mx-megamenu__submenu').hide();
                            $(el).on('mouseenter', function() {
                                $(el).next('.mx-megamenu__submenu').show();
                            });

                            $(el).next('.mx-megamenu__submenu').on('mouseleave', function() {
                                $(this).hide();
                            });
                        }
                    });
                },
                /**
                 * Switch to Mobile Version.
                 */
                exit: function () {
                    var $item,
                        $items;

                    // Init sidebar links. Add link class for sidebar elements
                    self._initSideBarLinks();

                    self.element.find('.mx-megamenu__item > .mx-megamenu__link').on('click', function(e) {
                        $item = $(e.target).closest('.mx-megamenu__item');

                        if (self._canShowSubmenu($(e.target))) {
                            // Open, close
                            e.preventDefault();

                            if (!$item.hasClass('current')) {
                                if ($item.hasClass('level0')) {
                                    $items = $('.level0.mx-megamenu__item');
                                }

                                if ($item.hasClass('level1')) {
                                    $items = $('.level1.mx-megamenu__item');
                                }

                                if ($items.length) {
                                    $items.not($item).removeClass('current');
                                }
                            }

                            $item.toggleClass('current');
                            
                        }
                    });
                }
            });
        },

        // Sidebar items with "menu-sidebar__item" class can be handled as generated links
        _initSideBarLinks: function() {
            this.element.find('.menu-sidebar__item').each(function(i, item) {
                $(item).addClass('mx-megamenu__item').addClass('level1');
                $(item).find('h4, a').addClass('mx-megamenu__link');
                $(item).find('ul').addClass('mx-megamenu__submenu');
            });
        },

        _canShowSubmenu: function($item) {
            var $link = $item.closest('.mx-megamenu__link');

            return this._hasSubmenu($link) || $link.next('.mx-megamenu__submenu').length
        },

        _hasSubmenu: function($item) {
            return $item.next('.mx-megamenu__submenu').length == 1;
        }
    });




    return $.mx.megaMenu;
    
    
    
});
