$(document).ready(function () {


	$("html").niceScroll();
    
    /* تسريع ال سلايدر */
    $('.carousel').carousel({
        interval: 4000
    });

    var formErrors = true;

    $(document).on('blur', '#NickName', function() {

        if($(this).val().length <= 5) {

            $(this).css('border', '2px solid #F00');
            $(this).parent().find('.NickName_error').fadeIn(200);
            formErrors = true;

        } else {

            $(this).css('border', '2px solid #080');
            $(this).parent().find('.NickName_error').fadeOut(200);
            formErrors = false;

        }

    });

    $(document).on('submit', '#NickName_Form', function(e) {

        if(formErrors === true) {

            e.preventDefault();
            $(this).find('#NickName').css('border', '2px solid #F00');
            $(this).find('.NickName_error').fadeIn(200);

        }

    });

    var username = true,
        password = true,
        Nationality = true,
        Full_Name = true,
        sex = true,
        Day_of_birth = true,
        Month_of_birth = true,
        Year_of_birth = true;

    $(document).on('blur', '#username', function() {

        if($(this).val().length <= 5) {

            $(this).css('border', '2px solid #F00');
            $(this).parent().find('.username').fadeIn(200);
            username = true;


        } else {

            $(this).css('border', '2px solid #080');
            $(this).parent().find('.username').fadeOut(200);
            username = false;

        }

    });

    $(document).on('blur', '#password', function() {

        if($(this).val().length <= 8) {

            $(this).css('border', '2px solid #F00');
            $(this).parent().find('.password').fadeIn(200);
            password = true;


        } else {

            $(this).css('border', '2px solid #080');
            $(this).parent().find('.password').fadeOut(200);
            password = false;

        }

    });

    $(document).on('blur', '#Nationality', function() {

        if($(this).val() === '') {

            $(this).css('border', '2px solid #F00');
            $(this).parent().find('.Nationality').fadeIn(200);
            Nationality = true;


        } else {

            $(this).css('border', '2px solid #080');
            $(this).parent().find('.Nationality').fadeOut(200);
            Nationality = false;

        }

    });

    $(document).on('blur', '#Full_Name', function() {

        if($(this).val() === '') {

            $(this).css('border', '2px solid #F00');
            $(this).parent().find('.Full_Name').fadeIn(200);
            Full_Name = true;


        } else {

            $(this).css('border', '2px solid #080');
            $(this).parent().find('.Full_Name').fadeOut(200);
            Full_Name = false;

        }

    });

    $(document).on('change', '#sex', function() {

        if($(this).val() === '0') {

            $(this).css('border', '2px solid #F00');
            $(this).parent().find('.sex').fadeIn(200);
            sex = true;


        } else {

            $(this).css('border', '2px solid #080');
            $(this).parent().find('.sex').fadeOut(200);
            sex = false;

        }

    });

    $(document).on('change', '#Day_of_birth', function() {

        if($(this).val() === '0') {

            $(this).css('border', '2px solid #F00');
            $(this).parent().find('.Day_of_birth').fadeIn(200);
            Day_of_birth = true;


        } else {

            $(this).css('border', '2px solid #080');
            $(this).parent().find('.Day_of_birth').fadeOut(200);
            Day_of_birth = false;

        }

    });

    $(document).on('change', '#Month_of_birth', function() {

        if($(this).val() === '0') {

            $(this).css('border', '2px solid #F00');
            $(this).parent().find('.Month_of_birth').fadeIn(200);
            Month_of_birth = true;


        } else {

            $(this).css('border', '2px solid #080');
            $(this).parent().find('.Month_of_birth').fadeOut(200);
            Month_of_birth = false;

        }

    });

    $(document).on('change', '#Year_of_birth', function() {

        if($(this).val() === '0') {

            $(this).css('border', '2px solid #F00');
            $(this).parent().find('.Year_of_birth').fadeIn(200);
            Year_of_birth = true;


        } else {

            $(this).css('border', '2px solid #080');
            $(this).parent().find('.Year_of_birth').fadeOut(200);
            Year_of_birth = false;

        }

    });

    $(document).on('submit', '#memebership_form', function(e) {

        if(username === true || password === true || Nationality === true || Full_Name === true || sex === true || Day_of_birth === true || Month_of_birth === true || Year_of_birth === true) {

            e.preventDefault();
            $(this).parent().find('.memebership_submit').fadeIn(200);

        }

    });

    var Complaints = true;

    $(document).on('blur', '#Complaints_text', function() {

        if($(this).val().length <= 60) {

            $(this).css('border', '2px solid #f00');
            $(this).parent().find('.Complaints_error').fadeIn(200);
            Complaints = true;

        } else {

            $(this).css('border', '2px solid #080');
            $(this).parent().find('.Complaints_error').fadeOut(200);
            Complaints = false;

        }

    });

    $(document).on('submit', '#Complaints_Form', function(e) {

        if(Complaints === true) {

            e.preventDefault();
            $(this).find('.Complaints_error').fadeIn(200);

        }

    });

    var Comment = true;

    $(document).on('blur', '#Comment_textarea', function() {

        if($(this).val().length <= 3) {

            $(this).parent().find('.Add_Comment_error').fadeIn(200);
            $(this).css('border', '2px solid #f00');
            Comment = true;

        } else {

            $(this).parent().find('.Add_Comment_error').fadeOut(200);
            $(this).css('border', '2px solid #080');
            Comment = false;

        }

    });

    $(document).on('submit', '#Add_Comment_Form', function(e) {

        if(Comment == true) {

            e.preventDefault();
            $(this).find('.Add_Comment_error').fadeIn(200);
            $('#Comment_textarea').css('border', '2px solid #f00');

        }

    });

});


// Loading Overlay Section Start //
$(window).load(function () {
    
    'use strict';
    
    // Loading Elemaint
    $(".loading-overlay .spinner").fadeOut(2000,
        function () {
        
        // Show The Scroll --------------------
            $("body").css("overflow", "auto");//  -
        // ------------------------------------
            $(this).parent().fadeOut(2000,
                function () {
                    $(this).remove();
                });
        });
});
// Loading Overlay Section End //