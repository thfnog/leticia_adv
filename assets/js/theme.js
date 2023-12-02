(function($) {
    'use strict';

    if ($('.accrodion-grp').length) {
        var accrodionGrp = $('.accrodion-grp');
        accrodionGrp.each(function() {
            var accrodionName = $(this).data('grp-name');
            var Self = $(this);
            var accordion = Self.find('.accrodion');
            Self.addClass(accrodionName);
            Self.find('.accrodion .accrodion-content').hide();
            Self.find('.accrodion.active').find('.accrodion-content').show();
            accordion.each(function() {
                $(this).find('.accrodion-title').on('click', function() {
                    if ($(this).parent().hasClass('active') === false) {
                        $('.accrodion-grp.' + accrodionName).find('.accrodion').removeClass('active');
                        $('.accrodion-grp.' + accrodionName).find('.accrodion').find('.accrodion-content').slideUp();
                        $(this).parent().addClass('active');
                        $(this).parent().find('.accrodion-content').slideDown();
                    };


                });
            });
        });

    };

    if ($('.scroll-to-target').length) {
        $(".scroll-to-target").on('click', function() {
            var target = $(this).attr('data-target');
            // animate
            $('html, body').animate({
                scrollTop: $(target).offset().top
            }, 1000);

            return false;

        });
    }

    function isotopeActivator() {
        if ($('.masonary-layout').length) {
            $('.masonary-layout').isotope({
                layoutMode: 'masonry',
                itemSelector: '.masonary-item',

            });
        }
        if ($('.masonary-layout-no-grid-width').length) {
            $('.masonary-layout-no-grid-width').isotope({
                layoutMode: 'masonry',
                itemSelector: '.masonary-item'
            });
        }

        if ($('.post-filter').length) {
            var postFilterList = $('.post-filter li');
            postFilterList.children('span').on('click', function() {
                var Self = $(this);
                var selector = Self.parent().attr('data-filter');
                postFilterList.children('span').parent().removeClass('active');
                Self.parent().addClass('active');


                $('.filter-layout').isotope({
                    filter: selector,
                    animationOptions: {
                        duration: 500,
                        easing: 'linear',
                        queue: false
                    }
                });
                return false;
            });
        }

        if ($('.post-filter.has-dynamic-filter-counter').length) {
            // var allItem = $('.single-filter-item').length;

            var activeFilterItem = $('.post-filter.has-dynamic-filter-counter').find('li');

            activeFilterItem.each(function() {
                var filterElement = $(this).data('filter');
                var count = $('.gallery-content').find(filterElement).length;
                $(this).children('span').append('<span class="count"><b>' + count + '</b></span>');
            });
        }
    }

    if ($('.brand-carousel-one').length) {
        $('.brand-carousel-one').owlCarousel({
            loop: true,
            margin: 30,
            nav: false,
            navText: [
                '<i class="fa fa-long-arrow-left"></i>',
                '<i class="fa fa-long-arrow-right"></i>'
            ],
            dots: true,
            autoWidth: false,
            autoplay: true,
            smartSpeed: 700,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 2
                },
                480: {
                    items: 3
                },
                600: {
                    items: 3
                },
                991: {
                    items: 3
                },
                1000: {
                    items: 4
                },
                1200: {
                    items: 4
                }
            }
        });
    }

    if ($('.brand-two__carousel').length) {
        $('.brand-two__carousel').owlCarousel({
            loop: true,
            margin: 90,
            nav: false,
            navText: [
                '<i class="fa fa-long-arrow-left"></i>',
                '<i class="fa fa-long-arrow-right"></i>'
            ],
            dots: false,
            autoWidth: false,
            autoplay: true,
            smartSpeed: 700,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 2,
                    margin: 20
                },
                480: {
                    items: 3
                },
                600: {
                    items: 3
                },
                991: {
                    items: 4
                },
                1000: {
                    items: 6
                },
                1200: {
                    items: 6
                }
            }
        });
    }

    if ($('.testimonials-two__carousel').length) {
        $('.testimonials-two__carousel').owlCarousel({
            loop: true,
            margin: 0,
            items: 1,
            nav: false,
            navText: [
                '<i class="fa fa-long-arrow-left"></i>',
                '<i class="fa fa-long-arrow-right"></i>'
            ],
            dots: true,
            autoWidth: false,
            autoplay: true,
            smartSpeed: 700,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
        });
    }

    if ($('.social-statics-one__carousel').length) {
        $('.social-statics-one__carousel').owlCarousel({
            loop: true,
            margin: 0,
            items: 1,
            nav: false,
            navText: [
                '<i class="fa fa-long-arrow-left"></i>',
                '<i class="fa fa-long-arrow-right"></i>'
            ],
            dots: true,
            autoWidth: false,
            autoplay: true,
            smartSpeed: 700,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
        });
    }


    if ($('.banner-carousel__one').length) {
        $('.banner-carousel__one').owlCarousel({
            loop: true,
            items: 1,
            margin: 0,
            dots: true,
            nav: false,
            animateOut: 'slideOutDown',
            animateIn: 'fadeIn',
            active: true,
            smartSpeed: 1000,
            autoplay: 5000
        });
        $('.banner-carousel-btn__left-btn').on('click', function() {
            $('.banner-carousel__one').trigger('next.owl.carousel');
            return false;
        });
        $('.banner-carousel-btn__right-btn').on('click', function() {
            $('.banner-carousel__one').trigger('prev.owl.carousel');
            return false;
        });
    }

    if ($('.tabbed-carousel-one__carousel').length) {
        var tabbedCarousel = $('.tabbed-carousel-one__carousel');
        var dotsBlock = $('.tabbed-carousel-one__content');

        // dynamic count for carousel
        tabbedCarousel.on('initialize.owl.carousel changed.owl.carousel', function(e) {
            var idx = e.item.index;
            var carouselCount = e.item.count;

            if (!e.namespace) {
                return;
            }
            var carousel = e.relatedTarget;
            dotsBlock.find('.tabbed-carousel-one__single').removeClass('active');
            dotsBlock.find('.tabbed-carousel-one__single').eq(carousel.relative(carousel.current())).addClass('active');
        }).owlCarousel({
            loop: true,
            items: 1,
            margin: 0,
            dots: false,
            nav: false,
            active: true,
            smartSpeed: 1000,
            autoplay: 5000
        });
        $('.tabbed-carousel-one__carousel-btn__left-btn').on('click', function() {
            $('.tabbed-carousel-one__carousel').trigger('prev.owl.carousel');
            return false;
        });
        $('.tabbed-carousel-one__carousel-btn__right-btn').on('click', function() {
            $('.tabbed-carousel-one__carousel').trigger('next.owl.carousel');
            return false;
        });

    }




    if ($('.stricky').length) {
        $('.stricky').addClass('original').clone(true).insertAfter('.stricky').addClass('stricked-menu').removeClass('original');
    }

    if ($('.testimonials-one__thumb-carousel').length) {
        var testiOneThumbCarousel = new Swiper('.testimonials-one__thumb-carousel', {
            slidesPerView: 1,
            spaceBetween: 0,
            freeMode: true,
            effect: 'fade',
            speed: 1400,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            loop: true,
            autoplay: {
                delay: 5000,
            },
        });
    }


    if ($('.testimonials-one__carousel').length) {
        var testiOneCarousel = new Swiper('.testimonials-one__carousel', {
            navigation: {
                nextEl: '.testimonials-one__left-btn',
                prevEl: '.testimonials-one__right-btn',
            },
            observer: true,
            observeParents: true,
            speed: 1400,
            mousewheel: true,
            autoplay: {
                delay: 5000,
            },
            thumbs: {
                swiper: testiOneThumbCarousel
            }
        });
    }

    if ($('.main-navigation .navigation-box .submenu').length) {
        var subMenu = $('.main-navigation .submenu');
        subMenu.parent('li').children('a').append(function() {
            return '<button class="sub-nav-toggler"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>';
        });
        var mainNavToggler = $('.header-navigation .menu-toggler');
        var subNavToggler = $('.main-navigation .sub-nav-toggler');
        mainNavToggler.on('click', function() {
            var Self = $(this);
            var menu = Self.closest('.header-navigation').find(Self.data('target'));
            $(menu).slideToggle();
            $(menu).toggleClass('showen');
            return false;
        });
        subNavToggler.on('click', function() {
            var Self = $(this);
            Self.parent().parent().children('.submenu').slideToggle();
            return false;
        });
    }

    $(window).on('scroll', function() {
        if ($('.scroll-to-top').length) {
            var strickyScrollPos = 100;
            if ($(window).scrollTop() > strickyScrollPos) {
                $('.scroll-to-top').fadeIn(500);
            } else if ($(this).scrollTop() <= strickyScrollPos) {
                $('.scroll-to-top').fadeOut(500);
            }
        }
        if ($('.stricked-menu').length) {
            var headerScrollPos = 100;
            var stricky = $('.stricked-menu');
            if ($(window).scrollTop() > headerScrollPos) {
                stricky.addClass('stricky-fixed');
            } else if ($(this).scrollTop() <= headerScrollPos) {
                stricky.removeClass('stricky-fixed');
            }
        }
    });
    $(window).on('load', function() {
        isotopeActivator();
        if ($('.preloader').length) {
            $('.preloader').fadeOut('slow');
        }
    });

})(jQuery);