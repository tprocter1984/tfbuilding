$(document).ready(function () {

    function getSlickSettings(slide_element) {
        return {
            dots: false,
            infinite: true,
            speed: 300,
            slide: slide_element,
            slidesToShow: 4,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1280,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 640,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        }
    }

    var fct_gallery = $('.fct_gallery .images');
    var fct_page_links = $('.fct_page_links_with_text .pods');
    var gallery_container = $('#gallery-container');

    if (fct_gallery.is(':visible')) {
        fct_gallery.slick(getSlickSettings('.image'));

        $('.image').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });

    }

    if (fct_page_links.is(':visible')) {
        fct_page_links.slick(getSlickSettings('.pod'));
    }

    if (gallery_container.is(':visible')) {
        gallery_container.slick(getSlickSettings('.item'));
        $('.popmeup').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });
    }

});

$(window).load(function () {
    //console.log( "window loaded" );
});

$(window).resize(function () {

    var fct_gallery = $('.fct_gallery .images');
    var fct_page_links = $('.fct_page_links_with_text .pods');
    var gallery_container = $('#gallery-container');
    
    if ($(window).width() > 1280) {

        if (fct_gallery.is(':visible')) {
            fct_gallery.slick('slickGoTo', '0');
        }

        if (fct_page_links.is(':visible')) {
            fct_page_links.slick('slickGoTo', '0');
        }

        if (gallery_container.is(':visible')) {
            gallery_container.slick('slickGoTo', '0');
        }

    }

});