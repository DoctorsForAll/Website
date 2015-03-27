$("#contactForm")
    .submit(function (event) {
        event.preventDefault();
        $('#send').button('sent').attr("disabled", true);

        $.post(
            'sendemail.php', {
                email: $("#email").val(),
                message: $("#message").val()
            },
            function (data) {},
            "text"
        );
    });