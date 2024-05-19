<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Confirm Order | Cleckhuddersfax Market Hub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../CSS/main.css">

    <style>

        .main-content{
            display: flex;
        }

        .order{
            flex: 4;
            margin: 6vw;
            margin-right: 7vw;
        }

        .payment{
            flex: 1;
            margin: 3vw;
            margin-right: 7vw;
            padding: 3vw;
            background-color: whitesmoke;
        }

        .order-item{
            display: flex;
            justify-content: space-between;
        }

        .item-photo{
            flex: 15%;
        }

        .item-name{
            flex: 50%;
            align-self: center;
        }

        .item-price{
            flex: 10%;
            align-self: center;
        }
        
        .item-edit{
            flex: 25%;
        }

        .payment section{
            margin-bottom: 2vw;
        }

        .payment div{
            margin-top: 2vw;
        }

        @media (max-width: 1188px){
            .main-content{
                flex-direction: column;
            }

            .order{
                margin: 6vw;
                margin-top: 3vw;
            }

            .payment{
                margin: 9vw;
                margin-top: 0;
            }
        }

        @media (max-width: 765px){
            .order-item{
                flex-direction: column;
            }

            .img-fluid{
                width: auto;
                height: auto;
            }

            .item-edit{
                align-self: center;
            }

            .payment{
                margin: 12vw;
                margin-top: 0;
            }
        }
    </style>
</head>

<body>
    <?php include "header.php"; ?>
    
    <div class="main-content">
        <div class="order">
            <div class="box">
                <section>
                    <span>Collection Slot:</span>
                    <span>Lorem Ipsum</span>
                </section>
                <section>
                    <span>Email the invoice to:</span>
                    <span>john.doe@gmail.com</span>
                </section>
            </div>

            <div class="box">
                <section class="order-item">
                    <div class="item-photo">
                        <img class="img-fluid" src="../../Image/products/product1.jpeg" alt="Order Item 1" width="70" height="70">
                    </div>
                    <div class="item-name">Lorem Ipsum</div>
                    <div class="item-price"><b>$25.00</b></div>
                    <div class="item-edit">
                        <img class="img-fluid" src="../../Image/buttons/edit.png" alt="">
                        <img class="img-fluid" src="../../Image/buttons/delete.png" alt="">
                    </div>
                </section>
                <hr>
                <section class="order-item">
                    <div class="item-photo">
                        <img class="img-fluid" src="../../Image/products/product2.jpeg" alt="Order Item 1" width="70" height="70">
                    </div>
                    <div class="item-name">Lorem Ipsum</div>
                    <div class="item-price"><b>$9.00</b></div>
                    <div class="item-edit">
                        <img class="img-fluid" src="../../Image/buttons/edit.png" alt="">
                        <img class="img-fluid" src="../../Image/buttons/delete.png" alt="">
                    </div>
                </section>
            </div>
        </div>

        <div class="payment">
            <section>
                <b>Payment method</b>
            </section>

            <section class="mb-3">
                <img src="../../Image/paypal.png" alt="Payment Option 1" width="170" height="45">
            </section>
            <hr>
            <section class="mt-3">
                <div>
                    <b>Summary</b>
                </div>
                <div>
                    <span>Subtotal</span>
                    <span>$34.00</span>
                </div>
                <div>
                    <span>Total</span>
                    <span>$34.00</span>
                </div>
            </section>
            
            <section>
                <button class="btn btn-outline-success" type="submit"><small>Proceed to payment</small></button>
            </section>
        </div>
    </div>

    <?php include "footer.php"; ?>
</body>

</html>