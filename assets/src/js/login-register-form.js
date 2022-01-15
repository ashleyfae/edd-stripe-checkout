import {show, hide} from './helpers/toggleDisplay';

const loginToggles = document.querySelectorAll( '.register-login-toggle' );
if ( loginToggles ) {
    loginToggles.forEach( toggle => {
        toggle.addEventListener( 'click', toggleLoginRegister );
    } )
}

function toggleLoginRegister( e ) {
    const button = this,
        registerHeading = document.getElementById( 'register-heading' ),
        registerForm = document.getElementById( 'register' ),
        loginHeading = document.getElementById( 'login-heading' ),
        loginForm = document.getElementById( 'login' );

    if ( button.getAttribute( 'data-id' ) === 'register' ) {
        // They want to log in.
        hide( registerHeading );
        hide( registerForm );

        show( loginHeading );
        show( loginForm );

        const loginEmail = loginForm.querySelector( 'input[type="email"]' );

        if ( loginEmail ) {
            loginEmail.focus();
        }
    } else {
        // They want to register.
        hide( loginHeading );
        hide( loginForm );

        show( registerHeading );
        show( registerForm );

        const registerEmail = registerForm.querySelector( 'input[type="email"]' );

        if ( registerEmail ) {
            registerEmail.focus();
        }
    }
}
