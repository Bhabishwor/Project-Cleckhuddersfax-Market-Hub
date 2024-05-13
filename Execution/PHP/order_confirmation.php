<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Confirm Order | Cleckhuddersfax Market Hub</title>

    <style>
        .body{
            background-color: #e3e3e3;
        }

        .box{
            padding: 1vw;
            margin: 2vw;
            background-color: white;
        }

        .main-div{
            display: flex;
            font-size: 1vw;
        }

        .div1{
            flex: 4;
            margin: 6vw;
            margin-right: 7vw;
        }

        .div2{
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

        .item-div1{
            flex: 15%;
        }

        .item-div2{
            flex: 50%;
            align-self: center;
        }

        .item-div3{
            flex: 10%;
            align-self: center;
        }
        
        .item-div4{
            flex: 25%;
        }

        .summary{
            margin-top: 3vw;
        }

        .div2 section{
            margin-bottom: 2vw;
        }

        .div2 div{
            margin-top: 3vw;
        }
    </style>
</head>

<body class="body">
    <?php include "header.php"; ?>
    
    <div class="main-div">
        <div class="div1">
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
                    <div class="item-div1"><img src="../Image/products/product1.jpeg" alt="Order Item 1" width="70" height="70"></div>
                    <div class="item-div2">Lorem Ipsum</div>
                    <div class="item-div3">
                        <b>$25.00</b>
                    </div>
                    <div class="item-div4">
                        <img src="../Image/buttons/edit.png" alt="" width="70" height="70">
                        <img src="../Image/buttons/delete.png" alt="" width="70" height="70">
                    </div>
                </section>
                <hr>
                <section class="order-item">
                    <div class="item-div1"><img src="../Image/products/product2.jpeg" alt="Order Item 1" width="70" height="70"></div>
                    <div class="item-div2">Lorem Ipsum</div>
                    <div class="item-div3">
                        <b>$9.00</b>
                    </div>
                    <div class="item-div4">
                        <img src="../Image/buttons/edit.png" alt="" width="70" height="70">
                        <img src="../Image/buttons/delete.png" alt="" width="70" height="70">
                    </div>
                </section>
            </div>
        </div>

        <div class="div2">
            <section>
                <h5><b>Payment method</b></h5>
            </section>

            <section>
                <img src="../Image/paypal.png" alt="Payment Option 1" width="170" height="45">
            </section>
            
            <section class="summary">
                <hr>
                <div>
                    <b>Summary</b>
                </div>
                <div>
                    <span>Subtotal</span>
                    <span>$34.00</span>
                </div>
                <div class="total">
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