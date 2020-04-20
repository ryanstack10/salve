function getShopItems() {
    $.post("getItems.php", function(returnData, status) {
        var itemArr = JSON.parse(returnData);
        sessionStorage.setItem('allItemArr', returnData);
        var colCount = 0;
        var rowCount = 0;
        for (var i = 0; i < itemArr.length; i++) {
            if (itemArr[i][4] > 0) {
                $("#itemListCol" + rowCount).append('<div class="column" itemId="' + itemArr[i][0] + '" onClick="location.href=\'productDetails.php?ind=' + i + '\'"><div><img src="images/' + itemArr[i][5] + '"></div><div>' + itemArr[i][1] + '<div><div>' + itemArr[i][2] + '</div><div>$' + new Number(itemArr[i][3]).toFixed(2) + '</div></div>');
                colCount++;
                if (colCount == 3) {
                    colCount = 0;
                    rowCount++;
                    $("#itemList").append('<div id="itemListCol' + rowCount + '" class="row"></div>');
                }
            }
        }
    });
}

function addToCart(quantity) {
    var cartArr = JSON.parse(sessionStorage.getItem('cartArr'));
    let params = new URLSearchParams(location.search);
    var index = params.get('ind');
    var b = true;
    for (var i = 0; i < cartArr.length; i++) {
        if (cartArr[i][0] == index) {
            cartArr[i][1] = new Number(cartArr[i][1]) + new Number(quantity);
            sessionStorage.setItem('cartArr', JSON.stringify(cartArr));
            b = false;
        }
    }
    if (b) {
        cartArr.push([index, quantity]);
        sessionStorage.setItem('cartArr', JSON.stringify(cartArr));
    }
}

function getProductDetails() {
    var cartArr = JSON.parse(sessionStorage.getItem('cartArr'));
    let params = new URLSearchParams(location.search);
    var index = params.get('ind');
    var productArr = JSON.parse(sessionStorage.getItem('allItemArr'))[index];
    $("#imageDiv").append('<img src="images/' + productArr[5] + '" width=90% style="margin-top:20px;">');
    $("#nameDiv").append(productArr[1]);
    $("#descriptionDiv").append(productArr[2]);
    $("#priceDiv").append("$" + new Number(productArr[3]).toFixed(2) + " each");
    $("#stockNumDiv").append("Number in stock: " + productArr[4]);
    for (var i = 1; i <= productArr[4]; i++) {
        $('#quantitySelect').append('<option value="' + i + '">' + i + '</option>');
    }
}

function resetCart() {
    var arr = [];
    sessionStorage.setItem('cartArr', JSON.stringify(arr));
}

function purchase() {
    var cartArr = JSON.parse(sessionStorage.getItem('cartArr'));
    var productArr = JSON.parse(sessionStorage.getItem('allItemArr'));
    var finalPurchaseArr = [];
    for (var i = 0; i < cartArr.length; i++) {
        finalPurchaseArr.push([productArr[cartArr[i][0]][0], cartArr[i][1]]);
    }
    $.ajax({
        type: 'POST',
        url: 'purchase.php',
        data: {
            'cart': JSON.stringify(finalPurchaseArr)
        },
        dataType: 'json'
    });
    resetCart();
    document.location = "afterPurchase.php";
}

function addQuantity(productId, cartId) {
    var cartArr = JSON.parse(sessionStorage.getItem('cartArr'));
    var productArr = JSON.parse(sessionStorage.getItem('allItemArr'));
    if (cartArr[cartId][1] < productArr[productId][4]) {
        cartArr[cartId][1] = new Number(cartArr[cartId][1]) + 1;
        sessionStorage.setItem('cartArr', JSON.stringify(cartArr));
        var quanId = document.getElementById("quantity" + cartArr[cartId][0]);
        quanId.innerHTML = "Quantity: " + cartArr[cartId][1];
        var costId = document.getElementById("cost" + cartArr[cartId][0]);
        costId.innerHTML = 'Total Cost: $' + new Number(productArr[cartArr[cartId][0]][3] * cartArr[cartId][1]).toFixed(2);
    }
}

function subQuantity(productId, cartId) {
    var cartArr = JSON.parse(sessionStorage.getItem('cartArr'));
    var productArr = JSON.parse(sessionStorage.getItem('allItemArr'));
    if (cartArr[cartId][1] > 0) {
        cartArr[cartId][1] = new Number(cartArr[cartId][1]) - 1;
        sessionStorage.setItem('cartArr', JSON.stringify(cartArr));
        var quanId = document.getElementById("quantity" + cartArr[cartId][0]);
        quanId.innerHTML = "Quantity: " + cartArr[cartId][1];
        var costId = document.getElementById("cost" + cartArr[cartId][0]);
        costId.innerHTML = 'Total Cost: $' + new Number(productArr[cartArr[cartId][0]][3] * cartArr[cartId][1]).toFixed(2);
    }
}

function getCartItems() {
    var cartArr = JSON.parse(sessionStorage.getItem('cartArr'));
    var productArr = JSON.parse(sessionStorage.getItem('allItemArr'));
    var colCount = 0;
    var rowCount = 0;
    for (var i = 0; i < cartArr.length; i++) {
        if (productArr[cartArr[i][0]][4] < cartArr[i][1]) {
            cartArr[i][1] = productArr[cartArr[i][0]][4];
            sessionStorage.setItem('cartArr', JSON.stringify(cartArr));
        }
        $("#itemListCol" + rowCount).append('<div class="columnCart" itemId="' + cartArr[i][0] + '"><div><img src="images/' + productArr[cartArr[i][0]][5] + '"></div><div>' + productArr[cartArr[i][0]][1] + '<div><div id="quantity' + cartArr[i][0] + '">Quantity: ' + cartArr[i][1] + '</div><div id="cost' + cartArr[i][0] + '">Total Cost: $' + new Number(productArr[cartArr[i][0]][3] * cartArr[i][1]).toFixed(2) + '</div><div><button onclick="addQuantity(' + cartArr[i][0] + ', ' + i + ')">+</button><button onclick="subQuantity(' + cartArr[i][0] + ', ' + i + ')">-</button></div></div>');
        colCount++;
        if (colCount == 3) {
            colCount = 0;
            rowCount++;
            $("#itemList").append('<div id="itemListCol' + rowCount + '" class="row"></div>');
        }
    }
}

function displayFile() {
    var image = document.getElementById('imgUpload');
    image.src = URL.createObjectURL(event.target.files[0]);
}

function dropFunc(i) {
    $("#dropDiv" + i).toggleClass("show");
}

function getHistory() {
    $.post("getOrders.php", function(ordersData, status) {
        var orders = JSON.parse(ordersData);

        for (var i = 0; i < orders.length; i++) {
            $("#historyContent").append('<div class="dropdown"><button class="dropbtn" onclick="dropFunc(' + i + ')" id="dropbutton">Order #' + orders[i] + ' <i class="fa fa-caret-down"></i></button></div><div class="dropdown-content" id="dropDiv' + i + '"></div>');
            $.when(addHistoryItems(orders[i], i));
        }
    });
}

function addHistoryItems(order_id, i) {
    $.post("getOrderItems.php", {
        'order_id': order_id
    }, function(itemData, status) {
        var orderItems = JSON.parse(itemData);
        console.log(itemData);
        for (var j = 0; j < orderItems.length; j++) {
            console.log(j + " " + orderItems[j][0]);
            $("#dropDiv" + i).append('<div>Name: ' + orderItems[j][0] + ' Quantity: ' + orderItems[j][1] + '</div>');
        }
    });
}