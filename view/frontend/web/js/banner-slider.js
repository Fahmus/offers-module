// define(['jquery', 'swiper'], function ($, Swiper) {
//     'use strict';
//
//     return function () {
//         new Swiper('.offers-banner-slider', {
//             loop: true,
//             autoplay: {
//                 delay: 5000,
//             },
//             pagination: {
//                 el: '.swiper-pagination',
//                 clickable: true,
//             },
//             navigation: {
//                 nextEl: '.swiper-button-next',
//                 prevEl: '.swiper-button-prev',
//             },
//             effect: 'flip',
//         });
//     };
// });

define(['jquery', 'swiper'], function ($, Swiper) {
    return function (config, element) {
        $.ajax({
            url: config.url,
            type: 'GET',
            data: {
                'categoryId': config.categoryId
            },
            success: function (html) {
                if (html) {
                    $(element).html(html);
                    new Swiper($(element).find('.swiper-container')[0], {
                        loop: true,
                        autoplay: {
                            delay: 5000,
                        },
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true
                        },
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev'
                        },
                        effect: 'flip',
                    });
                }
            }
        });
    };
});
