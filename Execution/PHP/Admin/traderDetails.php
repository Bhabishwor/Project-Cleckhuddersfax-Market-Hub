<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trader Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <style>
        .trader_search {
            display: flex;
            float: left;
        }

        .search_bar{
            margin-left: 2rem;
        }
    </style>
</head>

<body>
        <?php
        include "admin_navigation_pane.php";
        ?>
    <div class="container trader_search mt-3 mb-3">
        <h3>Trader</h3>
        <form class="d-flex search_bar" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>
    <div class="table_container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Trader</th>
                    <th scope="col">Email</th>
                    <th scope="col">Status</th>
                    <th scope="col">Shop Name</th>
                    <th scope="col">Amend</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">
                        <i class="icon fas fa-user"></i>
                    </th>
                    <td>John Doe</td>
                    <td>JohnDoe@gmail.com</td>
                    <td>Enabled</td>
                    <td>Bakery Union</td>
                    <td>
                        <button type="button" class="btn btn-primary">Edit</button>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <i class="icon fas fa-user"></i>
                    </th>
                    <td>John Doe</td>
                    <td>JohnDoe@gmail.com</td>
                    <td>Enabled</td>
                    <td>Bakery Union</td>
                    <td>
                        <button type="button" class="btn btn-primary">Edit</button>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <i class="icon fas fa-user"></i>
                    </th>
                    <td>John Doe</td>
                    <td>JohnDoe@gmail.com</td>
                    <td>Enabled</td>
                    <td>Bakery Union</td>
                    <td>
                        <button type="button" class="btn btn-primary">Edit</button>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <i class="icon fas fa-user"></i>
                    </th>
                    <td>John Doe</td>
                    <td>JohnDoe@gmail.com</td>
                    <td>Enabled</td>
                    <td>Bakery Union</td>
                    <td>
                        <button type="button" class="btn btn-primary">Edit</button>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <i class="icon fas fa-user"></i>
                    </th>
                    <td>John Doe</td>
                    <td>JohnDoe@gmail.com</td>
                    <td>Enabled</td>
                    <td>Bakery Union</td>
                    <td>
                        <button type="button" class="btn btn-primary">Edit</button>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <i class="icon fas fa-user"></i>
                    </th>
                    <td>John Doe</td>
                    <td>JohnDoe@gmail.com</td>
                    <td>Enabled</td>
                    <td>Bakery Union</td>
                    <td>
                        <button type="button" class="btn btn-primary">Edit</button>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <i class="icon fas fa-user"></i>
                    </th>
                    <td>John Doe</td>
                    <td>JohnDoe@gmail.com</td>
                    <td>Enabled</td>
                    <td>Bakery Union</td>
                    <td>
                        <button type="button" class="btn btn-primary">Edit</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>

</html>