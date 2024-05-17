<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<style>
    .authentication_search {
        display: flex;
        float: left;
        margin-left: 0;
    }

    .search_bar {
        margin-left: 2rem;
    }


    .authentication {
        display: grid;
    }


    .trader_approval {}

    body {
        background-color: darkgray;
    }

    .trader {
        background-color: white;
        margin: 1rem;
    }

    .layout-container {
        display: flex;
        /* flex-flow: row nowrap; */
        /* Arrange side-by-side */
    }


    /* Authentication content */
    .authentication {
        flex: 1;
        /* Take up remaining space */
        padding: 1rem;
    }
</style>

<body>
    <div class="layout-container">


        <?php
        include "admin_navigation_pane.php";
        ?>
        <div class="authentication">
            <div class="container authentication_search mt-3 mb-3">
                <h2>Authentication</h2>
                <form class="d-flex search_bar" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>

            <div class="container trader_approval">

                <div class="trader border rounded">
                    <p>Joh Doe</p>
                    <div class="email d-flex text-center">
                        <i class="fa-solid fa-envelope"></i>
                        <p>JohDoe@gmail.com</p>
                    </div>
                    <div class="shopName d-flex">
                        <i class="fa-solid fa-envelope"></i>
                        <p>BeautySaloon</p>
                    </div>
                    <div class="confirmation d-block">
                        Confirm Order:
                        <div class="confirm_btn">
                            <button type="button" class="btn btn-success">Success</button>
                            <button type="button" class="btn btn-danger">Danger</button>
                        </div>
                    </div>
                </div>

                <div class="trader border rounded">
                    <p>Joh Doe</p>
                    <div class="email d-flex text-center">
                        <i class="fa-solid fa-envelope"></i>
                        <p>JohDoe@gmail.com</p>
                    </div>
                    <div class="shopName d-flex">
                        <i class="fa-solid fa-envelope"></i>
                        <p>BeautySaloon</p>
                    </div>
                    <div class="confirmation d-block">
                        Confirm Order:
                        <div class="confirm_btn">
                            <button type="button" class="btn btn-success">Success</button>
                            <button type="button" class="btn btn-danger">Danger</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>

</html>