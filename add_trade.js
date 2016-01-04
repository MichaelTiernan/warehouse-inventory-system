$(document).ready(function () {

    $("#productButton button").on('click', function () {
        var value = $(this).attr("name");
        var go = true;
        $("#result input").each(function () {
            if ($(this).attr('name') === 's_id[]' && $(this).val() === value) {
                go = false;
            }
        });
        if (go) {
            $.ajax ({
                type: 'post',
                url: 'trade_form.php',
                data: {
                    p_name: value
                },
                success: function (data) {
                    $("#result").append(data)
                }
            });
        }
    });
});