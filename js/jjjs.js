document.addEventListener('DOMContentLoaded', () => {
    // Carrito
    const btnCart = document.querySelector('#contain-cart-icon');
    const contCartProducts = document.querySelector('.cont-car-product');

    btnCart.addEventListener('click', () => {
        contCartProducts.classList.toggle('hidden-car');
    });

    const cartInfo = document.querySelector('.car-product');
    const rowProduct = document.querySelector('.row-product');
    const productList = document.querySelector('#container-item');

    // Recuperar productos del localStorage al cargar la página
    let allProducts = JSON.parse(localStorage.getItem('order')) || [];

    const valorTotal = document.querySelector('.total-pagar');
    const countProduct = document.querySelector('#contador-productos');
    const cartEmpty = document.querySelector('.cart-empty');
    const cartTotal = document.querySelector('.car-total');

    const updateLocalStorage = () => {
        localStorage.setItem('order', JSON.stringify(allProducts));
    };

    const showHTML = () => {
        if (!allProducts.length) {
            cartEmpty.classList.remove('hidden');
            rowProduct.classList.add('hidden');
            cartTotal.classList.add('hidden');
        } else {
            cartEmpty.classList.add('hidden');
            rowProduct.classList.remove('hidden');
            cartTotal.classList.remove('hidden');
        }

        // Limpiar HTML
        rowProduct.innerHTML = '';

        let total = 0;
        let totalOfProducts = 0;

        allProducts.forEach(product => {
            const containProduct = document.createElement('div');
            containProduct.classList.add('car-product');

            containProduct.innerHTML = `
                <div id="info-car-product">
                    <span id="cantidad-car">${product.quantity}</span>
                    <p id="titulo-car">${product.title}</p>
                    <span id="precio-product-car">${product.precio}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon-close">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            `;

            rowProduct.append(containProduct);

            // Eliminar el símbolo de dólar y los puntos, y convertir a float
            const precioSinFormato = product.precio.replace(/\./g, '').replace('$', '').trim();
            total += product.quantity * parseFloat(precioSinFormato);
            totalOfProducts += product.quantity;
        });

        // Mostrar total con dos decimales
        valorTotal.innerText = `$${total.toFixed(2)}`;
        countProduct.innerText = totalOfProducts;
    };

    productList.addEventListener('click', e => {
        if (e.target.classList.contains('btn-add-cart')) {
            const product = e.target.parentElement;

            const infoProduct = {
                quantity: 1,
                title: product.querySelector('h1').textContent,
                precio: product.querySelector('p').textContent,
            };

            const exists = allProducts.some(p => p.title === infoProduct.title);

            if (exists) {
                allProducts = allProducts.map(p => {
                    if (p.title === infoProduct.title) {
                        p.quantity++;
                    }
                    return p;
                });
            } else {
                allProducts.push(infoProduct);
            }

            updateLocalStorage(); // Actualizar localStorage
            showHTML();
        }
    });

    rowProduct.addEventListener('click', e => {
        if (e.target.classList.contains('icon-close')) {
            const product = e.target.parentElement;
            const title = product.querySelector('#titulo-car').textContent;

            allProducts = allProducts.filter(p => p.title !== title);
            updateLocalStorage(); // Actualizar localStorage
            showHTML();
        }
    });

    showHTML(); // Mostrar el carrito al cargar la página

    // Manejo del botón de pagar
    const btnPay = document.querySelector('#btn-pagar');
    btnPay.addEventListener('click', () => {
        window.location.href = '../../factura.html'; // Cambia la ruta según sea necesario
    });
});
