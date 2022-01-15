/* global restBase */

/**
 * Makes an API request.
 *
 * @param {string} endpoint
 * @param {string} method
 * @param {object} body
 */
export default function apiRequest( endpoint, method, body = {} ) {
    const args = {
        method,
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json'
        },
    };

    if ( Object.keys( body ).length ) {
        args.body = JSON.stringify( body );
    }

    return fetch( restBase + '/' + endpoint, args )
        .then( response => {
            if ( ! response.ok ) {
                return Promiose.reject( response );
            }

            return response.json();
        } );
}
