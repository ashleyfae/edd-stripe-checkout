import apiRequest from "./helpers/apiRequest";

const cartItems = document.querySelectorAll( '.cart-item' );
if ( cartItems ) {
    cartItems.forEach( item => {
        const removeButton = item.querySelector( '.cart-item--remove' );

        if ( ! removeButton ) {
            return;
        }

        removeButton.addEventListener( 'click', e => {
            e.preventDefault();

            const cartKey = item.getAttribute( 'data-id' );
            if ( ! cartKey ) {
                console.log( 'Missing cart key.' );
                return;
            }

            removeButton.classList.add( 'loading' );
            removeButton.disabled = true;

            apiRequest( 'cart/' + cartKey, 'DELETE' )
                .then( response => {
                    item.remove();
                } )
                .catch( error => {
                    console.log( 'Error removing from cart', error );
                } )
        } );
    } );
}
