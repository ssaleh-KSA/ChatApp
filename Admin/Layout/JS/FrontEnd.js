$(document).ready(function () {


	$("html").niceScroll();
    
    /* تسريع ال سلايدر */
    $('.carousel').carousel({
        interval: 4000
    });

    var newsTitle = true,
        newsImage = true,
        newsDetails = true;

    $(document).on('blur', '#News_Title', function() {

        if($(this).val().length <= 5) {

            $(this).css('border', '2px solid #f00');
            $(this).parent().find('.News_Title').fadeIn(200);
            newsTitle = true;

        } else {

            $(this).css('border', '2px solid #080');
            $(this).parent().find('.News_Title').fadeOut(200);
            newsTitle = false;

        }

    });

    $(document).on('change', '#News_Image', function() {

        if($(this).val() === '') {

            $(this).css('border', '2px solid #f00');
            $(this).parent().find('.News_Image').fadeIn(200);
            newsImage = true;

        } else {

            $(this).css('border', '2px solid #080');
            $(this).parent().find('.News_Image').fadeOut(200);
            newsImage = false;

        }

    });

    $(document).on('blur', '#News_Details', function() {

        if($(this).val().length <= 300) {

            $(this).css('border', '2px solid #f00');
            $(this).parent().find('.News_Details').fadeIn(200);
            newsDetails = true;

        } else {

            $(this).css('border', '2px solid #080');
            $(this).parent().find('.News_Details').fadeOut(200);
            newsDetails = false;

        }

    });

    $(document).on('submit', '#News_Form', function(e) {

        if(newsTitle === true || newsImage === true || newsDetails === true) {

            e.preventDefault();
            $(this).find('.News_Form').fadeIn(200);

        }

    });

    var Complaints_Answer = true;

    $(document).on('blur', '#Complaints_Answer_box', function() {

        var Answer_Value = $(this).val();
        if($(this).val().length < 20) {

            $(this).css('border', '2px solid #f00');
            $(this).parent().find('.Complaints_Answer_box_error').fadeIn(200);
            Complaints_Answer = true;

        } else {

            $(this).css('border', '2px solid #080');
            $(this).parent().find('.Complaints_Answer_box_error').fadeOut(200);
            Complaints_Answer = false;

        }

    });

    $(document).on('submit', '#Complaints_Answer', function(e) {

        if(Complaints_Answer == true) {

            e.preventDefault();
            $(this).find('#Complaints_Answer_box').css('border', '2px solid #f00');
            $(this).parent().find('.Complaints_Answer_box_error').fadeIn(200);

        }

    });

    $(document).on('click', '.Complaints_ID', function() {

        var Complaints_ID = $(this).attr('id');
        var action = 'Delete_Complaints';
        if(confirm("هل أنت متأكد من حذف هذه الشكوى?")) {

            $.ajax({

                url: 'Admin_Delete.php',
                method: 'POST',
                data: {action: action, Complaints_ID: Complaints_ID},
                beforeSend: function() {

                $('.IDis_'+Complaints_ID+'').parent().html('<img src="../img/1.gif" style="width: 20px;height: 18px;">');

                },
                success: function() {

                    $('.Com_ID_'+Complaints_ID+'').css('background-color', '#CCC');
                    $('.Com_ID_'+Complaints_ID+'').fadeOut(1500);

                }

            });

        } else {

            return false;

        }

    });

    var News_Delete = true;

    $(document).on('click', '.News_Delete', function() {

        if(confirm("خل تريد حذف هذا الخبر؟")) {

            var News_ID = $(this).attr('id');
            var action = 'News_Delete';
            $.ajax({

                url: 'Admin_Delete.php',
                method: 'POST',
                data: {action: action, News_ID: News_ID},
                beforeSend: function() {

                    $('.News_ID_'+News_ID+'').parent().html('<img src="../img/1.gif" style="width: 20px;height: 18px;">');

                },
                success: function() {

                    $('#N_ID_'+News_ID+'').css('background-color', '#CCC');
                    $('#N_ID_'+News_ID+'').fadeOut(1500);

                }

            });

        } else {

            return false;

        }

    });

    $(document).on('click', '.Delete_Mumber', function() {

        if(confirm('هل تريد فعلاً حذف هذا العضو؟')) {

            var Member_ID = $(this).attr('id');
            var action = 'Delete_Mumber';
            $.ajax({

                url: 'Admin_Delete.php',
                method: 'POST',
                data: {action: action, Member_ID: Member_ID},
                beforeSend: function() {

                    $('.Member_ID_'+Member_ID).parent().html('<img src="../img/1.gif" style="width: 20px;height: 18px;">');

                },
                success: function(data) {

                    $('#row_ID_'+Member_ID).css('background-color', '#CCC');
                    $('#row_ID_'+Member_ID).fadeOut(1500);

                }

            });

        } else {

            return false;

        }

    });

    $(document).on('click', '.Delete_Abuse', function() {

        if(confirm('هل تريد فعلاً حذف هذه البلاغ؟')) {

            var Abuse_ID = $(this).attr('id');
            var action = 'Delete_Abuse';
            $.ajax({

                url: 'Admin_Delete.php',
                method: 'POST',
                data: {action: action, Abuse_ID: Abuse_ID},
                beforeSend: function() {

                    $('.Abuse_ID_'+Abuse_ID).parent().html('<img src="../img/1.gif" style="width: 20px;height: 18px;">');

                },
                success: function() {

                    $('#Abuse_row_ID_'+Abuse_ID).css('background-color', '#CCC');
                    $('#Abuse_row_ID_'+Abuse_ID).fadeOut(1500);

                }

            });

        } else {

            return false;

        }

    });

    $(document).on('click', '.Delete_chat_Text', function() {

        if(confirm('هل تريد فعلاً حذف هذه الرسالة؟')) {

            var Chat_Text_ID = $(this).attr('id');
            var Abuse_ID = $(this).attr('data-Abuse-ID')
            var action = 'Delete_Chat_Text';

            $.ajax({

                url: 'Admin_Delete.php',
                method: 'POST',
                data: {action: action, Chat_Text_ID: Chat_Text_ID, Abuse_ID: Abuse_ID},
                beforeSend: function() {

                    $('.chat_Text_ID_'+Chat_Text_ID).parent().html('<img src="../img/1.gif" style="width: 20px;height: 18px;">');

                },
                success: function() {

                    $('.Abuse_Remove_'+Chat_Text_ID).html('<b>تم حذف النص</b>');
                    $('#Abuse_row_ID_'+Abuse_ID).css('background-color', '#CCC');
                    $('#Abuse_row_ID_'+Abuse_ID).fadeOut(1500);

                }

            });

        } else {

            return false;

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