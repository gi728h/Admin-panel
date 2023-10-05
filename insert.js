var svg = '<button class="submit"></button>'
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
        sessionStorage.setItem("insert", "TRUE");
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
        console.log("insert sucessful")
        event.stopPropagation();
    })
    event.stopPropagation();
    return false;
})
})