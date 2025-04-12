(function() {
    const mobileMenuBtn = document.querySelector('#menu');
    const closeButton = document.querySelector('#close-menu')
    const nav = document.querySelector('.sidebar');
    addMenuListener(mobileMenuBtn, closeButton);
    correctMobileStyles();

    function addMenuListener(menu, closeButton) {
        if(!menu || !closeButton) {
            return;
        }

        menu.addEventListener('click', function() {
            nav.classList.add('show-nav');
            nav.classList.remove('close-nav');
        });

        closeButton.addEventListener('click', function() {
            nav.classList.add('close-nav');

            setTimeout(() => {
                nav.classList.remove('show-nav');
            }, 500)
        })
    }

    function correctMobileStyles() {
        window.addEventListener('resize', function() {
            const windowWidth = document.body.clientWidth;
            if (windowWidth >= 768) {
                nav.classList.remove('show-nav');
                nav.classList.remove('close-nav');
            }
        })
    }
})();