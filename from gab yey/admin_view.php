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
<br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5">
                <div class="table-responsive">
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
                            include_once 'retrieve_user_info.php';
                        ?>
                    </table>
                </div>
            </div>
            <div class="col-md-5">
                <div class="table-responsive">
                    <table class="table table-striped table-dark">
                        <thead>
                            <tr>
                                <th>Device ID</th>
                                <th>Owner's Email</th>
                            </tr>
                        </thead>
                        <?php
                            include_once 'retrieve_device_data.php';
                        ?>
                    </table>
                </div>
            </div>
            
        </div>
        
        
    </div>
    
</head>
  
</html>