var attri
var values
var selected_element
var table
var selected_value
$("tr .v").click((event) => {
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

$(".delete").click((event) => {
    console.log($(event.target).attr("class"))
    table = $(event.target).attr("class").split(" ")[0]
    var parent1 = $(event.target).parent()
    console.log(parent1.parent())
    attri = []
    values = []
    $(parent1.parent()).children().each((index, element) => {
        try {
            attri.push($(element).attr('class').split(" ")[2]);
            values.push($(element).text());
        } catch (error) {
            console.log(error)
        }
    })
    $.ajax({
        async: true,
        type: "POST",
        url: "http://localhost/Test/delete.php",
        data: {
            "table": table,
            "attribute": attri,
            "value": values,
        },
        success: function (data) {
            console.log("success " + data);
        },
        error:
            function (data) {
                console.log('An error occurred.');
                console.log(data);
            }
    })
    location.reload();
})
var svg = '<svg class="submit" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-upload" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383z"/><path fill-rule="evenodd" d="M7.646 4.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V14.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3z"/></svg>'
$(() => {

$(".create").off().on('click',(event) => {
    var section = $(event.target).parent();
    var table = section[0].getElementsByTagName("table")[0]
    console.log(table)
    var row = table.getElementsByTagName("tr")[0]
    var count = row.childElementCount
    row = table.insertRow();
    for (var i = 0; i <= count; i++) {
        var cell = row.insertCell(-1);
        cell.contentEditable;
        if (i != count) {
            cell.innerHTML = "<form><input type='text'></input></form>";
        } else {

            cell.innerHTML = svg;
        }
    }


    $(".submit").click((event) => {
        parent = $(event.target).parent().parent();
        table = parent.parent().parent().attr("class")
        values = []
        $(parent).children().each((index, element) => {
            try {
                values.push(element.getElementsByTagName("input")[0].value)
            } catch (error) {
                console.log(error)
            }
        })
        console.log(table)
        console.log(values)
        $.ajax({
            async: true,
            type: "POST",
            url: "http://localhost/Test/insert.php",
            data: {
                "table": table,
                "values": values,
            },
            success: function (data) {
                console.log("success " + data);
            },
            error:
                function (data) {
                    console.log('An error occurred.');
                    console.log(data);
                }
        })
        location.reload();
        event.stopPropagation();
    })
    event.stopPropagation();
    return false;
})
})