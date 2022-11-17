<?php

session_start();                                // altijd hiermee starten als je gebruik wilt maken van sessiegegevens

function getCart(){
    if (isset($_SESSION['cart'])) {               //controleren of winkelmandje (=cart) al bestaat
        $cart = $_SESSION['cart'];                  //zo ja:  ophalen
    } else {
        $cart = array();                            //zo nee: dan een nieuwe (nog lege) array
    }
    return $cart;                               // resulterend winkelmandje terug naar aanroeper functie
}

function saveCart($cart){
    $_SESSION["cart"] = $cart;                  // werk de "gedeelde" $_SESSION["cart"] bij met de meegestuurde gegevens
}

function addProductToCart($stockItemID){
    $cart = getCart();                          // eerst de huidige cart ophalen

    if (array_key_exists($stockItemID, $cart)) {  //controleren of $stockItemID(=key!) al in array staat
        $cart[$stockItemID] += 1;                   //zo ja:  aantal met 1 verhogen
    } else {
        $cart[$stockItemID] = 1;                    //zo nee: key toevoegen en aantal op 1 zetten.
    }

    saveCart($cart);                            // werk de "gedeelde" $_SESSION["cart"] bij met de bijgewerkte cart
}
function removeProductFromCart($stockItemID){
    $cart = getCart();                          // eerst de huidige cart ophalen

    if (array_key_exists($stockItemID, $cart)) {  //controleren of $stockItemID(=key!) al in array staat
        $cart[$stockItemID] -= 1;                   //zo ja:  aantal met 1 verlagen
        if($cart[$stockItemID] <= 0) {
            unset($cart[$stockItemID]);             // verwijdert het product uit de winkelmand als de hoeveelheid kleiner dan of gelijk aan 0 is
        }
    }

    saveCart($cart);                            // werk de "gedeelde" $_SESSION["cart"] bij met de bijgewerkte cart
}
function deleteProductFromCart($stockItemID){
    $cart = getCart();

    if(array_key_exists($stockItemID, $cart)) {
        unset($cart[$stockItemID]);                 // verwijdert het product uit de winkelmand door het passende element uit de array te gooien
    }
    saveCart($cart);
}
function setProductAmmount($stockItemID, $amount) {
    $cart = getCart();
    $cart[$stockItemID] = $amount;
    saveCart($cart);
}
function addProductAmountToCart($stockItemID, $amount){
    $cart = getCart();                          // eerst de huidige cart ophalen

    if (array_key_exists($stockItemID, $cart)) {  //controleren of $stockItemID(=key!) al in array staat
        $cart[$stockItemID] += $amount;                   //zo ja:  aantal met 1 verhogen
    } else {
        $cart[$stockItemID] = $amount;                    //zo nee: key toevoegen en aantal op 1 zetten.
    }

    saveCart($cart);                            // werk de "gedeelde" $_SESSION["cart"] bij met de bijgewerkte cart
}