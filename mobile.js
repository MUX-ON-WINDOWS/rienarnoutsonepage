let portfolioWindow = document.getElementById("portfolioWindow");
let portfolioMobile = document.getElementById("portfolioMobile");

let switchPortfolioMobile = document.getElementById("switchPortfolioMobile1");
let switchPortfolioWindow = document.getElementById("switchPortfolioWindow1");

let switchPortfolioMobile2 = document.getElementById("switchPortfolioMobile2");
let switchPortfolioWindow2 = document.getElementById("switchPortfolioWindow2");

window.addEventListener('load', (event) => {
    viewportwidth = document.body.clientWidth

    if (viewportwidth <= 1200) {
        portfolioWindow = document.getElementById('portfolioWindow').style.display = "none";
        portfolioMobile = document.getElementById('portfolioMobile').style.display = "block";

        // Navbar fullscreen
        switchPortfolioMobile = document.getElementById('switchPortfolioMobile1').style.display = "block";
        switchPortfolioWindow = document.getElementById('switchPortfolioWindow1').style.display = "none";

        // Hamburger Menu
        switchPortfolioMobile2 = document.getElementById('switchPortfolioMobile2').style.display = "block";
        switchPortfolioWindow2 = document.getElementById('switchPortfolioWindow2').style.display = "none";

    } else if (viewportwidth >= 1200) {
        portfolioWindow = document.getElementById('portfolioWindow').style.display = "block";
        portfolioMobile = document.getElementById('portfolioMobile').style.display = "none";

        // Navbar fullscreen
        switchPortfolioMobile = document.getElementById('switchPortfolioMobile1').style.display = "none";
        switchPortfolioWindow = document.getElementById('switchPortfolioWindow1').style.display = "block";

        // Hamburger Menu
        switchPortfolioMobile2 = document.getElementById('switchPortfolioMobile2').style.display = "none";
        switchPortfolioWindow2 = document.getElementById('switchPortfolioWindow2').style.display = "block";
    }
    console.log('Portfolio fully loaded');
});

