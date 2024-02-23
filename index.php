<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Select - Option - Update Data In Database Without Reload Page</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
<!-- To Show Message -->
<div id="response"></div>
<table width="50%" border="1" cellspacing="0" cellpadding="0" style="text-align: center;">
    <thead>
        <th>Team</th>
        <th>Action</th>
    </thead>
    <tbody id="load_table">
        <!-- Display data here -->
    </tbody>
</table>
<script>
$(document).ready(function(){
    function loadData() {
        $.ajax({
            url: 'sql.php',
            success: function(response) {
                // Get data and show inside HTML/Tags
                $('#load_table').html(response);
            }
        });
    }

    loadData();

    $(document).on('change', '.updateData', function () {
        var data_id = $(this).attr('id');
        var data_val = $(this).val();
        $.ajax({
            url: "sql.php",
            type: "GET",
            data: {
                updateSelect: true,
                get_id: data_id,
                get_value: data_val
            },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if(res.status == 404) {
                    $('#response').text(res.message);
                } else if(res.status == 200){
                    loadData();
                    return false;
                }
            }
        });
    });
});
</script>
</body>
</html>
