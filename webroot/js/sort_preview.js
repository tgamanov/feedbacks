(function ($) {

    //Order by name and email function
    var orderType;
    var orderByName = function (element) {
        orderType = element;
        var orderBy = $(".feedback-item").sort(function (a, b) {
            var orderNameAZ = $(a).find(element).text() > $(b).find(element).text(),
                orderNameZA = $(a).find(element).text() < $(b).find(element).text();
            if (orderNameAZ) {
                return orderNameAZ;
            } else {
                return orderNameZA;
            }
        });
        $(".feedback-wrapper").html(orderBy);
    };

    //Buttons events - name, email, date
    var filterNavigation = function () {

        // Add active class to the button
        var selector = '.btn-group-justified .btn';
        $(selector).on('click', function () {
            $(selector).removeClass('active');
            $(this).addClass('active');
        });

        //Order by name on click
        $("#name-btn").on("click", function () {

            orderType = $(".f-name");
            orderByName(orderType);
        });

        //Order by email  on click
        $("#email-btn").on("click", function () {
            orderType = $(".f-email");
            orderByName(orderType);
        });

        //Order by date  on click
        $("#num-btn").on("click", function () {
            var orderByDate = $(".feedback-item").sort(function (a, b) {
                var dateASC = new Date($(a).find(".f-date").text()) < new Date($(b).find(".feedback-time").text()),
                    dateDESC = new Date($(a).find(".f-date").text()) > new Date($(b).find(".feedback-time").text());

                if (dateDESC) {
                    return dateDESC;
                } else {
                    return dateASC;
                }
            });
            $(".feedback-wrapper").html(orderByDate);
        });
    };

    //Hide validation messages
    var hideValidationMessage = function () {
        setTimeout(function () {
            $('.notice-box').fadeOut('fast');
        }, 3000);
    };

    //Preview section comments
    var previewSection = function () {
        $(window).load(function () {
            $("#preview-button").on("click", function () {
                var previewInfo = "<h3>" + $("#feedback-form input[name=name]").val() + "</h3>";
                previewInfo += "<p>" + "Email: " + $("#feedback-form input[name = email]").val() + "</p>";
                previewInfo += "<p>" + "Message: " + $("#feedback-form textarea[name = message]").val() + "</p>";
                $("#message-preview-wrapper").css("display", "block");
                $("#preview-block").html(previewInfo);
            });
        });
    };

    //Reset form
    $.fn.reset = function () {
        $(this).each (function() { this.reset(); });
    }

    $('#feedback-form').reset();

    filterNavigation();
    hideValidationMessage();
    previewSection();

})(jQuery);
