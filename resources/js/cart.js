// public/js/cart.js

function increaseQty(inputId)
{
    let input = document.getElementById(inputId);

    input.value++;
}

function decreaseQty(inputId)
{
    let input = document.getElementById(inputId);

    if(input.value > 1)
    {
        input.value--;
    }
}