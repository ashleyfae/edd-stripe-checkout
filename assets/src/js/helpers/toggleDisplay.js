/**
 * @param {HTMLElement} element
 */
export function show( element ) {
    element.classList.remove( 'display-none' );
    element.classList.add( 'display-block' );
}

/**
 * @param {HTMLElement} element
 */
export function hide( element ) {
    element.classList.remove( 'display-block' );
    element.classList.add( 'display-none' );
}
