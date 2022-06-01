<!DOCTYPE html>
<html>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<head>
    <title>
        Admin View Test
    </title>
</head>
  
<body style="text-align:center;">
         
    <div class="container-fluid">
        <img src="sexsex.png" style="width:128px;height:128px;">
        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <th>User Email</th>
                    <th>User Password</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Birth Date</th>
                </tr>
            </thead>
            <?php
                include 'retrieve_all_info.php';
            ?>
        </table>
    </div>
    
</head>
  
</html>