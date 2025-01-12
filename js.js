//Carrito
const btnCart = document.querySelector('#contain-cart-icon')
const contCartProducts = document.querySelector('.cont-car-product')

btnCart.addEventListener('click', () => {
    contCartProducts.classList.toggle('hidden-car')
})

//-------------------------------------------

const cartInfo = document.querySelector('.cart-product')
const rowProduct = document.querySelector('.row-product')

//lista de productos
const productList = document.querySelector('#container-item')

//arreglo de productos
let allProducts = []

const valorTotal = document.querySelector('.total-pagar');

const countProducts = document.querySelector('#contador-productos');

const cartEmpty = document.querySelector('.cart-empty');
const cartTotal = document.querySelector('.car-total');

productList.addEventListener('click', e => {
    if(e.target.classList.contains('btn-add-cart')){
        const product = e.target.parentElement;

        const infoProduct = {
            quantity: 1,
            title: productList.querySelector('h1').textContent,
            precio: productList.querySelector('p').textContent,
        };

        const exits = allProducts.some(
			product => product.title === infoProduct.title
		);

        allProducts = [...allProducts, infoProduct]

        showHTML();
    }
    
})

//mostrar en HTML

const showHTML = () => {

    allProducts.forEach(product => {
        const containerProduct = docuemnt.createElement('div')
        containerProduct.classList.add('cart-product')

    containerProduct.innerHTML = `
    
        <div id="info-car-product">
    
                <spam id="cantidad-car">${product.quantity}</spam>

                <p id="titulo-car">${product.title}</p>

                <span id="precio-product-car">${prduct.precio}</span>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon-close">

                <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                `

            rowProduct.append(containerProduct)
    })
    
}

//limpiar html

//login
