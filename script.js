// Navbar begin
    const hamburgerMenu = document.getElementById('hamburgerMenu');
    const homeLogo = document.getElementById('homeLogo');
    const hamburgerSwitch = document.getElementById('hamburgerSwitch');

    const closeSign = document.getAnimations('closeSign');
    const openSign = document.getAnimations('openSign');

    const closeOnClick = document.getElementById('closeOnClick');


    hamburgerSwitch.className = 'close'

    function openHamburger() {
        if (hamburgerSwitch.className = 'close') {
            hamburgerSwitch.className = 'open'
        }

        if (hamburgerSwitch.className = 'open') {
            document.getElementById('openSign').innerHTML = `
            <li class="nav-logo">
                <button onclick="closeHamburger()" >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </li>`
        }
    }
    function closeHamburger() {
        if (hamburgerSwitch.className = 'open') {
            hamburgerSwitch.className = 'close'
        }
        if (hamburgerSwitch.className = 'close') {
            document.getElementById('openSign').innerHTML = `
            <li class="nav-logo">
                <button onclick="openHamburger()" >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </li>`
        }
    }

    // onclick mobile navbar will close.
    closeOnClick.addEventListener("click", function(event) {
        if (hamburgerSwitch.className = 'open') {
            hamburgerSwitch.className = 'close'

            document.getElementById('openSign').innerHTML = `
            <li class="nav-logo">
                <button onclick="openHamburger()" >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </li>`

            closeSign.className = ''
            openSign.className = 'hide'
        }
    })

    // Check width size if mobile or windows is.
    homeLogo.className = '';

    window.addEventListener('load', (event) => {
        viewportwidth = document.body.clientWidth

        if (viewportwidth <= 1200) {
            changeLogoVis = document.getElementById('widthCheck').style.display = "none";

        } else if (viewportwidth >= 1200) {
            changeLogoVis = document.getElementById('widthCheck').style.display = "block";
        }

        console.log('page is fully loaded');
      });

    window.addEventListener("resize", function(event) {
        viewportwidth = document.body.clientWidth

        if (viewportwidth <= 800) {
            // console.log("Mobile View")
            hamburgerMenu.className = '';
            homeLogo.className = 'hide';
        } else if (viewportwidth >= 800) {
            // console.log("Window View")
            hamburgerMenu.className = 'hide';
            homeLogo.className = '';
        }
    })

    let changeLogoVis = document.getElementById('widthCheck')

    window.addEventListener("resize", function(event) {
        viewportwidth = document.body.clientWidth

        if (viewportwidth <= 1200) {
            changeLogoVis = document.getElementById('widthCheck').style.display = "none";

        } else if (viewportwidth >= 1200) {
            changeLogoVis = document.getElementById('widthCheck').style.display = "block";
        }
    })

    // Navbar end
    // Portfolio begin

    var buttonClass = document.getElementById("buttonClass")
    var buttonsActive = buttonClass.getElementsByClassName("buttonSwitch");

    for (var i = 0; i < buttonsActive.length; i++) {
        buttonsActive[i].addEventListener("click", function() {
            var current = document.getElementsByClassName("active");
            if (current.length > 0) {
                current[0].className = current[0].className.replace(" active", "");
            }
            this.className += " active";
        });
    }

    function pickBeeld(value) {
        let keramiek = document.getElementById('keramiekContent');
        let brons = document.getElementById('bronsContent');

        if (value == 'brons') {
            keramiek.className = 'hide';
            brons.className = '';
        } else if (value == 'keramiek') {
            brons.className = 'hide';
            keramiek.className =  '' ;
        }
    }
// Portfolio end
