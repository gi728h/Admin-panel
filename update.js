$("tr .v").click((event) => {
    $target_element = $(event.target)
    console.log("before: " + $(event.target).text())
    console.log($(event.target).attr('class'));
    var classes = $(event.target).attr('class').split(" ");
    table = classes[1]
    console.log(table)
    var parent1 = $(event.target).parent()
    attri = []
    values = []
    selected_element = classes[2]
    selected_value = $(event.target).text()
    $(parent1).children().each((index, element) => {
        console.log($(element).attr('class'))
        try {
            attri.push($(element).attr('class').split(" ")[2]);
            values.push($(element).text());
        } catch (error) {
            console.log(error)
        }

    })
    console.log(attri);
    console.log(values);
    event.stopPropagation();
})

$('tr .v').on('keypress', function (e) {
    if (e.key == "Enter" && e.shiftKey == false) {
        console.log("after: " + $(event.target).text())
        $.ajax({
            async: true,
            type: "POST",
            url: "http://localhost/Test/update.php",
            data: {
                "table": table,
                "attribute": attri,
                "value": values,
                "update": $(event.target).text(),
                "selectedElement": selected_element,
                "selectedValue": selected_value
            },
            success: function (data) {
                console.log("success " + data);
                if(data != 1){
                    $("body").append('<div class="alert alert-danger" role="alert">Error : Failed to Update.</div>')
                    sessionStorage.clear()
                    sleep(2000);
                    $(".alert").animate({
                            opacity: 0
                        },
                        5000,
                        function() {
                            $elementToDisappear.empty();
                        }
                    );
                }else{
                    $("body").append('<div class="alert alert-primary" role="alert">Updated Successfully.</div>')
                    sessionStorage.clear()
                    sleep(2000);
                    $(".alert").animate({
                            opacity: 0
                        },
                        5000,
                        function() {
                            $elementToDisappear.empty();
                        }
                    );
                }
            },
            error:
                function (data) {
                    console.log('An error occurred.');
                    console.log(data);
                }
        })
        $(event.target)[0].contentEditable = "false";
        $(event.target)[0].contentEditable = "true";
        return false;
    }
    event.stopPropagation();
});