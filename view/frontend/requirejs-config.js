var config = {
    paths: {
        swiper: 'Dnd_OffersBanner/js/swiper.min'
    },
    shim: {
        swiper: {
            deps: ['jquery'],
            exports: 'Swiper'
        }
    },
    map: {
        '*': {
            offersBannerAjaxLoader: 'Dnd_OffersBanner/js/banner-slider'
        }
    }
};
