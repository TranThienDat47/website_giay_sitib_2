(function(window, document, $, undefined) {
    "use strict";
    $(function() {

        if ($('#morris_bar').length) {
            Morris.Bar({
                element: 'morris_bar',
                data: [
                    { x: 1, y: 100 ,title: "test"},
                    { x: 2, y: 50 },
                    { x: 3, y: 25 },
                    { x: 4, y: 3 },
                    { x: 5, y: 4 }
                ],
                xkey: 'x',
                ykeys: ['y'],
                labels: ['Y'],
                   barColors: ['#5969ff'],
                     resize: true,
                        gridTextSize: '14px'

            });
        }

    });

})(window, document, window.jQuery);