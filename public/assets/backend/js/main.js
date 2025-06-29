
$(document).ready(function() {

	"use strict";

	/*============================================
	Alert Fade
	==============================================*/

    $(".danger-alert").fadeIn(1000).delay(5000).fadeOut(700);
    $(".alert-warning").fadeIn(1000).delay(5000).fadeOut(700);
    $(".alert-danger").fadeIn(1000).delay(5000).fadeOut(700);
    $(".alert-success").fadeIn(1000).delay(5000).fadeOut(700);

	/*============================================
	Datatables
	==============================================*/

    $('#datatable_cms').DataTable();


	/*============================================
	OnlyNumber
	==============================================*/

    $(".onlyNumber").on('keydown', function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
            // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                // let it happen, don't do anything
                return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    /*============================================
    Check length of Description
    ==============================================*/
    $("#description").on('keyup',function(){
        var characters = $(this).val().length;
        var maxlen = 400;
        var countlast = Math.ceil(maxlen - characters) ;

        if (characters>maxlen){

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'This field text is too long!',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                onOpen: function() {
                    var maanlms = document.getElementById("myAudio");
                    maanlms.play();
                }
            })

            $('#addpost_btn, #editpost_btn').prop("disabled",true);

            $("#count").css("color","red").css("background","yellow");

        }else{
            $('#addpost_btn, #editpost_btn').prop("disabled",false);
            $("#count").css("color","black");
            $("#count").css("background","#D4FCF6");
        }
        $("#count").text("Characters: " + countlast );

    });

});
