$(document).ready(function () {
    let activeLinkUrlLength = 1;
    let urlLengthNav = 19;
    let apartCounter = $('#counter1');
    let shopCounter = $('#counter2');
    let floorCounter = $('#counter4');
    let garageCounter = $('#counter3');
    let navigation = $('.my-nav-style');
    let url = $(location).attr('pathname');
    $('a[data-rel^=lightcase]').lightcase({
        maxWidth: 1920,
        maxHeight: 1200
    });
    $("body").fadeIn(900);
    
    function activeLink(url) {

        let urlArr = url.split('/');
        let urlFinal = urlArr.filter(function (empt) {
            return empt != '';
        });
        let activeUrl = urlFinal[1];
        if(urlFinal.length == activeLinkUrlLength){
            $('#home').addClass('active');

        }else {
            $('#'+activeUrl).addClass('active');

        }

    }
     function counter(maxCount,descr) {
         let number = parseInt(descr.html());
         if(number != maxCount) {
             let interval = setInterval(function () {
                 number++;
                 descr.html(number);
                 if (number == maxCount) {
                     clearInterval(interval);
                 }

             }, 20);
         }
     }
     console.log($(window).width());
    function navStyle() {
        if(url.length > urlLengthNav){

            $('.my-nav-style').css({

                'background-color': '#3f4448'
            });
            $('nav').addClass('sticky-top');
            $('nav').removeClass('fixed-top');
        }else {
            $('nav').addClass('fixed-top');
            if($(window).width()< 500){
                navigation.css({
                    'background-color': '#3f4448',
                    'padding': '5px 20px'
                })
            }else{
                $(window).scroll(function () {
                    if($(this).scrollTop() >20){
                        navigation.css({
                            'background-color': '#3f4448',
                            'padding': '20px'
                        })
                    }else{
                        navigation.css({
                            'background-color': 'transparent',
                            'padding': '40px'
                        })
                    }
                });
            }

        }
    }

    if($(window).scrollTop() >= 545.4545288085938){
        counter(32,apartCounter);
        counter(5,shopCounter);
        counter(5,floorCounter);
        counter(5,garageCounter);

    }

     $(window).scroll(function () {

         if($(this).scrollTop() >= 545.4545288085938){
             counter(32,apartCounter);
             counter(5,shopCounter);
             counter(5,floorCounter);
             counter(5,garageCounter);
         }

     });
     

    activeLink(url);
     navStyle();
      //-------table-------//
      $('#download-pdf').html('Свали ');
    let table = $('#apartment-table').DataTable( {
        lengthChange: false,
        searching: false,
        ordering: false,
        buttons: ['pdf']
    } );

    table.buttons().container()
        .appendTo( '#download-pdf' );

});