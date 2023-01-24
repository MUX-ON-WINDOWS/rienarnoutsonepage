<?php
declare(strict_types = 1);

if (isset($_POST['submit'])) {
    // get data from form.
    $name = htmlspecialchars(stripslashes(trim($_POST['full-name'])));
    $subject = htmlspecialchars(stripslashes(trim($_POST['subject'])));
    $email = htmlspecialchars(stripslashes(trim($_POST['email'])));
    $info = htmlspecialchars(stripslashes(trim($_POST['message'])));

    $message = "Naam: ".$name."\r\n"."Bericht: ".$info."\r\n";
    $headers =  "From: ".$email."\r\n";
    // Mail function and data
    mail('test@rienarnouts.nl', $subject, $message, $headers);

    echo '<p style="color: green">Message sent</p>';

    if (!preg_match("/^[A-Za-z .'-]+$/", $name)) {
        $name_error = 'Invalid name';
    }
    if (!preg_match("/^[A-Za-z .'-]+$/", $subject)) {
        $subject_error = 'Invalid subject';
    }
    if (!pregmatch("/^[A-Za-z0-9.%+-]+@[A-Za-z0-9.-]+.[A-Za-z]{2,4}$/", $email)) {
        $email_error = 'Invalid email';
    }
    if (strlen($message) === 0) {
        $message_error = 'Your message should not be empty';
    }
} else {
    echo '<p>Error occurred, please try again later</p>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Rien Arnouts</title>
    <!-- <link rel="stylesheet" href="node_modules/keen-slider/keen-slider.min.css" /> -->
    <script defer src="scripts.js"></script>
</head>

<body class="w-full h-full" style="margin-top: 0px;">
    <nav style="z-index: 99;" class="sticky">
            <div id="homeLogo" class="hide">
                <ul class="nav-wrapper">
                    <li class="nav-logo"><a href="#home"><img class="logo" src="logo/LogoRienArnouts.png"></a></li>
                    <li class="nav-item"><a class="nav-link rounded p-2" href="#about">Over mij</a></li>

                    <li id="switchPortfolioWindow1" class="nav-item"><a class="nav-link rounded p-2" href="#portfolioWindow">Portfolio</a></li>
                    <li id="switchPortfolioMobile1" class="nav-item"><a class="nav-link rounded p-2" href="#portfolioMobile">Portfolio</a></li>

                    <li class="nav-item"><a class="nav-link rounded p-2" href="#contact">Contact</a></li>
                </ul>
            </div>
            <div id="hamburgerMenu" class="hide">
                <div id="buttons" class="open">
                    <div id="openSign" class="mx-4">
                        <li class="nav-logo">
                            <button onclick="openHamburger()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </li>
                    </div>
                </div>
                <div id="hamburgerSwitch" class="close">
                    <ul class="nav-wrapper">
                    <div id="closeOnClick">
                        <li class="nav-item"><a class="nav-response-link rounded p-2" href="#home">Home</a></li>
                        <li class="nav-item"><a class="nav-response-link rounded p-2" href="#about">Over mij</a></li>

                        <li id="switchPortfolioWindow2" class="nav-item"><a class="nav-link rounded p-2" href="#portfolioWindow">Portfolio</a></li>
                        <li id="switchPortfolioMobile2" class="nav-item"><a class="nav-link rounded p-2" href="#portfolioMobile">Portfolio</a></li>

                        <li class="nav-item"><a class="nav-response-link rounded p-2" href="#contact">Contact</a></li>
                    </div>
                </ul>
                </div>
            </div>
    </nav>
    <!-- Start header -->
    <section id="home">
        <div class="relative" style="height: 950px; background-color: #DDC6B6;">
            <div class="lg:mx-auto lg:pr-0 xl:pr-36 lg:pl-0 xl:pl-14 lg:py-16 xl:py-24 absolute rounded-r-xl -mt-64" style="max-height: 1000px; top: 50%;">
                <img class="relative lg:h-full w-full" src="logo/LogoRienArnouts.png" >
            </div>
            <div id="widthCheck" class="px-20 py-20 h-5/8 absolute rounded-l-xl right-0" style="top: 260px; width: 45%; background-color: #262223;">
                <p id="visText" class="text-white relative leading-tight" style="font-size: 7rem; color: #DDC6B6;">
                    Atelier <br>
                    Rien Arnouts
                    <!-- Keramiek & <br> Brons -->
                </p>
            </div>
        </div>
    </section>
    <!-- Einde header -->
    <!-- Start video -->
    <section id="about">
        <div class="h-full mb-20">
            <div class="relative overflow-hidden py-16">
                <h1 class="my-4 text-center mx-auto">
                    <span class="text-3xl font-bold leading-8 tracking-tight text-gray-900 sm:text-4xl">Over mij</span>
                </h1>
                <div class="h-full grid grid-cols-1 gap-6 mx-20 sm:grid-cols-1 md::grid-cols-1 xl:grid-cols-2">
                    <div class="flex justify-center xl:p-6 lg:p-0">
                        <img class="rounded-xl w-full xl:h-full xl:w-full lg:w-2/3 md:1/2" src="img/workplace.jpg">
                    </div>
                    <div class="flex justify-center ">
                        <p id="text_aboutme" class="mt-8">
                            In zijn studietijd was Arnouts al bezig met onderzoek van de bolvorm en de
                            betekenis <br> voor zijn werk. Steeds meer wordt dit een uitgangspunt voor zijn
                            werk als symbool <br> voor de geboorte, aarde en kosmos.<br><br>

                            Al spoedig gaat hij over naar figuratieve vormgeving die vanuit de bolvorm ontstaat.<br><br>

                            Zijn werken in brons en keramiek kunnen als symbolisch worden geduid. <br>
                            Zijn vormgeving werkt suggestief, waarbij handen, gezichten, maar vooral
                            de vrouwelijke <br> torso belangrijke elementen zijn. De glazuren die als een
                            huid zijn werk omgeven,<br> hebben warme aardkleuren en geven dit werk een
                            uniek karakter. Voor de beschouwer <br> blijft er vanwege de openheid altijd een
                            eigen interpretatie van het aanschouwde mogelijk. <br><br>

                            <span class="font-bold"> Opleiding </span><br>
                            Academie Tilburg. Cursus keramische vormgeving in eigen atelier. <br><br>

                            <span class="font-bold"> Werken </span><br>
                            In bezit van Rijk, Gemeenten en particulieren in Nederland, België, <br> Duitsland, Frankrijk,
                            Noorwegen en Canada.<br><br>

                            <span class="font-bold"> Tentoonstellingen </span><br>
                            Amersfoort, Amsterdam, Bergen op Zoom, Breda, Deventer, Eindhoven, <br> Gulpen, Hoeven,
                            Nijmegen, Oosterhout, Raamsdonksveer, Zevenbergen, <br> Mechelen, Turnhout (B), Asten,
                            Bastogne (B) en Oisterwijk.<br>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Einde over mij -->
    <!-- Begin portfolio -->

    <!-- Window Portfolio -->
    <section id="portfolioWindow">
        <div class="h-full" style="background-color: #DDC6B6;">
        <div class="mx-auto w-full px-4 pt-12 sm:px-6 sm:pt-16 lg:max-w-7xl lg:px-8">
            <h1 class="my-4 text-center ml-auto">
                <span class="text-3xl font-bold leading-8 tracking-tight text-gray-900 sm:text-4xl">Portfolio</span>
            </h1>
            <div id="buttonClass" class="my-4 text-center ml-auto">
                <button onclick="pickBeeld('brons')" type="button" class="buttonSwitch active">Brons</button>
                <button onclick="pickBeeld('keramiek')" type="button" class="buttonSwitch">Keramiek</button>
            </div>
        </div>
        <div id="switchContent">
            <div id="bronsContent">
                <div class="mx-auto w-full px-4 pt-2 pb-16 sm:px-6 sm:pt-8 sm:pb-24 lg:max-w-7xl lg:px-8">
                    <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                        <a class="group">
                        <div class="grayoutimg relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="brons/cobra.jpg" class="h-full w-full object-cover object-center">
                            <p class="gallery__caption">Cobra</p>
                            <p class="gallery__cm">33 cm</p>
                        </div>
                        </a>

                        <a class="group">
                        <div class="grayoutimg relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="brons/jumeau.jpg" class="grayoutimg h-full w-full object-cover object-center">
                            <p class="gallery__caption">Jumeau</p>
                            <p class="gallery__cm">60 cm</p>
                        </div>
                        </a>

                        <a class="group">
                        <div class="grayoutimg relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="brons/marilyn.jpg" class="grayoutimg h-full w-full object-cover object-center">
                            <p class="gallery__caption">Marilyn</p>
                            <p class="gallery__cm">52 cm</p>
                        </div>
                        </a>

                        <a class="group">
                        <div class="grayoutimg relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="brons/sourire.jpg" class="h-full w-full object-cover object-center">
                            <p class="gallery__caption">Sourire</p>
                            <p class="gallery__cm">52 cm</p>
                        </div>
                        </a>

                        <a class="group">
                        <div class="grayoutimg relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="brons/uitdagend.jpg" class="h-full w-full object-cover object-center">
                            <p class="gallery__caption">Uitdagend</p>
                            <p class="gallery__cm">35 cm</p>
                        </div>
                        </a>

                        <a class="group">
                        <div class="grayoutimg relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="brons/vanity.jpg" class="h-full w-full object-cover object-center">
                            <p class="gallery__caption">Vanity</p>
                            <p class="gallery__cm">144 cm</p>
                        </div>
                        </a>

                        <a class="group">
                        <div class="grayoutimg relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="brons/volante.jpg" class="h-full w-full object-cover object-center">
                            <p class="gallery__caption">Volante</p>
                            <p class="gallery__cm">97 cm</p>
                        </div>
                        </a>

                        <a class="group">
                        <div class="grayoutimg relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="brons/voltige.jpg" class="h-full w-full object-cover object-center">
                            <p class="gallery__caption">Voltige</p>
                            <p class="gallery__cm">33 cm</p>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
            <div id="keramiekContent" class="hide">
                <div class="mx-auto w-full px-4 pt-2 pb-16 sm:px-6 sm:pt-8 sm:pb-24 lg:max-w-7xl lg:px-8">
                    <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                        <a class="group">
                        <div class="grayoutimg relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="keramiek/assis.jpg" class="h-full w-full object-cover object-center">
                            <p class="gallery__caption">Assis</p>
                            <p class="gallery__cm">40 cm</p>
                        </div>
                        </a>

                        <a class="group">
                            <div class="grayoutimg relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                                <img src="keramiek/beschouwend.jpg" class="grayoutimg h-full w-full object-cover object-center">
                                <p class="gallery__caption">Beschouwend</p>
                                <p class="gallery__cm">52 cm</p>
                            </div>
                            </a>

                        <a class="group">
                        <div class="grayoutimg relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="keramiek/bovenOnder.jpg" class="h-full w-full object-cover object-center">
                            <p class="gallery__caption">Boven & onder</p>
                            <p class="gallery__cm">24 cm</p>
                        </div>
                        </a>

                        <a class="group">
                        <div class="grayoutimg relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="keramiek/Overdenking.jpg" class="h-full w-full object-cover object-center">
                            <p class="gallery__caption">Overdenking</p>
                            <p class="gallery__cm">86 cm</p>
                        </div>
                        </a>

                        <a class="group">
                        <div class="grayoutimg relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="keramiek/tors.jpg" class="h-full w-full object-cover object-center">
                            <p class="gallery__caption">Tors</p>
                            <p class="gallery__cm">62 cm</p>
                        </div>
                        </a>

                        <a class="group">
                            <div class="grayoutimg relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                                <img src="keramiek/trio.jpeg" class="grayoutimg h-full w-full object-cover object-center">
                                <p class="gallery__caption">Trio</p>
                                <p class="gallery__cm">35 cm</p>
                            </div>
                            </a>

                            <a class="group">
                            <div class="grayoutimg relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                                <img src="keramiek/dialoog.jpg" class="h-full w-full object-cover object-center">
                                <p class="gallery__caption">Dialoog</p>
                                <p class="gallery__cm">32 cm</p>
                            </div>
                            </a>

                        <a class="group">
                        <div class="grayoutimg relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="keramiek/relief.jpg" class="h-full w-full object-cover object-center">
                            <p class="gallery__caption">Relief</p>
                            <p class="gallery__cm">94 cm</p>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <!-- Mobile Portfolio -->
    <section id="portfolioMobile" >
        <div class="h-full" style="background-color: #DDC6B6;">
        <div class="mx-auto w-full px-4 pt-12 sm:px-6 sm:pt-16 lg:max-w-7xl lg:px-8">
            <h1 class="my-4 text-center ml-auto">
                <span class="text-3xl font-bold leading-8 tracking-tight text-gray-900 sm:text-4xl">Portfolio</span>
            </h1>
        </div>
        <div>
            <!-- Brons Content Mobile -->
            <div>
                <h2 class="my-4 text-center ml-auto">
                    <span class="font-bold leading-6 text-gray-900 sm:text-3xl">Brons</span>
                </h2>
                <div class="mx-auto w-full px-4 pt-2 pb-16 sm:px-6 sm:pt-8 sm:pb-24 lg:max-w-7xl lg:px-8">
                    <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                        <a class="group">
                        <div class="relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="brons/cobra.jpg" class="h-full w-full object-cover object-center">
                            <p class="gallery_textName">Cobra</p>
                            <p class="gallery_cmText">33 cm</p>
                        </div>
                        </a>

                        <a class="group">
                        <div class="relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="brons/jumeau.jpg" class="h-full w-full object-cover object-center">
                            <p class="gallery_textName">Jumeau</p>
                            <p class="gallery_cmText">60 cm</p>
                        </div>
                        </a>

                        <a class="group">
                        <div class="relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="brons/marilyn.jpg" class="h-full w-full object-cover object-center">
                            <p class="gallery_textName">Marilyn</p>
                            <p class="gallery_cmText">52 cm</p>
                        </div>
                        </a>

                        <a class="group">
                        <div class="relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="brons/sourire.jpg" class="h-full w-full object-cover object-center">
                            <p class="gallery_textName">Sourire</p>
                            <p class="gallery_cmText">52 cm</p>
                        </div>
                        </a>

                        <a class="group">
                        <div class="relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="brons/uitdagend.jpg" class="h-full w-full object-cover object-center">
                            <p class="gallery_textName">Uitdagend</p>
                            <p class="gallery_cmText">35 cm</p>
                        </div>
                        </a>

                        <a class="group">
                        <div class="relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="brons/vanity.jpg" class="h-full w-full object-cover object-center">
                            <p class="gallery_textName">Vanity</p>
                            <p class="gallery_cmText">144 cm</p>
                        </div>
                        </a>

                        <a class="group">
                        <div class="relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="brons/volante.jpg" class="h-full w-full object-cover object-center">
                            <p class="gallery_textName">Volante</p>
                            <p class="gallery_cmText">97 cm</p>
                        </div>
                        </a>

                        <a class="group">
                        <div class="relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="brons/voltige.jpg" class="h-full w-full object-cover object-center">
                            <p class="gallery_textName">Voltige</p>
                            <p class="gallery_cmText">33 cm</p>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Brons Content Mobile Stop -->
            <!-- Keramiek Content Mobile Start -->
            <div>
                <h2 class="my-4 text-center ml-auto">
                    <span class="font-bold leading-6 text-gray-900 sm:text-3xl">Keramiek</span>
                </h2>
                <div class="mx-auto w-full px-4 pt-2 pb-16 sm:px-6 sm:pt-8 sm:pb-24 lg:max-w-7xl lg:px-8">
                    <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                        <a class="group">
                        <div class="relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="keramiek/assis.jpg" class="h-full w-full object-cover object-center">
                            <p class="gallery_textName">Assis</p>
                            <p class="gallery_cmText">40 cm</p>
                        </div>
                        </a>

                        <a class="group">
                            <div class="relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                                <img src="keramiek/beschouwend.jpg" class="h-full w-full object-cover object-center">
                                <p class="gallery_textName">Beschouwend</p>
                                <p class="gallery_cmText">52 cm</p>
                            </div>
                            </a>

                        <a class="group">
                        <div class="relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="keramiek/bovenOnder.jpg" class="h-full w-full object-cover object-center">
                            <p class="gallery_textName">Boven & onder</p>
                            <p class="gallery_cmText">24 cm</p>
                        </div>
                        </a>

                        <a class="group">
                        <div class="relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="keramiek/Overdenking.jpg" class="h-full w-full object-cover object-center">
                            <p class="gallery_textName">Overdenking</p>
                            <p class="gallery_cmText">86 cm</p>
                        </div>
                        </a>

                        <a class="group">
                        <div class="relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="keramiek/tors.jpg" class="h-full w-full object-cover object-center">
                            <p class="gallery_textName">Tors</p>
                            <p class="gallery_cmText">62 cm</p>
                        </div>
                        </a>

                        <a class="group">
                            <div class="relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                                <img src="keramiek/trio.jpeg" class="h-full w-full object-cover object-center">
                                <p class="gallery_textName">Trio</p>
                                <p class="gallery_cmText">35 cm</p>
                            </div>
                            </a>

                            <a class="group">
                            <div class="relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                                <img src="keramiek/dialoog.jpg" class="h-full w-full object-cover object-center">
                                <p class="gallery_textName">Dialoog</p>
                                <p class="gallery_cmText">32 cm</p>
                            </div>
                            </a>

                        <a class="group">
                        <div class="relative aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="keramiek/relief.jpg" class="h-full w-full object-cover object-center">
                            <p class="gallery_textName">Relief</p>
                            <p class="gallery_cmText">94 cm</p>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- Einde portfolio -->
    <!-- Begin Event -->

    <!-- <section id="agenda">
        <div class="h-full mb-20">
            <div class="relative overflow-hidden py-16">
                <h1 class="my-4 text-center mx-auto">
                    <span class="text-3xl font-bold leading-8 tracking-tight text-gray-900 sm:text-4xl">Agenda</span>
                </h1>
                <div class="mx-auto my-auto h-full max-w-7xl px-4 sm:px-6 lg:px-8">
                    <ul role="list" class="space-y-3">
                        <h1 class="text-2xl font-bold leading-8 tracking-tight text-gray-900 sm:text-2xl">14 september en 16 september 2019</h1>
                        <li class="overflow-hidden bg-white px-4 py-12 sm:rounded-md sm:px-6" style="background-color: #DDC6B6;">
                            <div class="flex">
                                <div class="w-1/3">09:00 AM - 04:00 PM</div>
                                <div class="w-1/2">
                                    <h1 class="text-2xl font-semibold leading-8 tracking-tight text-gray-900 sm:text-2xl">Open Ateliers Oosterhout</h1>
                                    <p>Location: Oosterhout, Venkelhof 6</p>
                                </div>
                            </div>
                        </li>
                        <h1 class="text-2xl font-bold leading-8 tracking-tight text-gray-900 sm:text-2xl">16 september en 17 september 2019</h1>
                        <li class="overflow-hidden bg-white px-4 py-12 sm:rounded-md sm:px-6" style="background-color: #DDC6B6;">
                            <div class="flex">
                                <div class="w-1/3">09:00 AM - 04:00 PM</div>
                                <div class="w-1/2">
                                    <h1 class="text-2xl font-semibold leading-8 tracking-tight text-gray-900 sm:text-2xl">Brabant Art Fair</h1>
                                    <p>Location: Breda, Markt, Grote Kerk Breda</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section> -->

    <!-- Einde Event -->
    <!-- Begin Contact -->
    <section id="contact">
        <div class="h-full">
            <div class="relative overflow-hidden py-16">
                <h1 class="my-4 mb-14 text-center mx-auto">
                    <span class="text-3xl font-bold leading-8 tracking-tight text-gray-900 sm:text-4xl">Contact</span>
                </h1>
                <div class="h-full grid grid-cols-1 gap-6 mx-20 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2">
                    <iframe class="w-full" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2475.300861409357!2d4.876090715970081!3d51.65432770777031!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c69968eef9c87d%3A0xce85afb569654a7e!2sVenkelhof%206%2C%204907%20HK%20Oosterhout!5e0!3m2!1snl!2snl!4v1664954550942!5m2!1snl!2snl"
                        height="450" style="border:0;"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" id="myForm"
                        class="grid grid-cols-1 gap-y-6">
                        <div>
                            <label for="full-name" class="sr-only">Volledige naam:</label>
                            <input type="text" name="full-name" id="full-name" autocomplete="name"
                            class="contactFormData block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm"
                            placeholder="Naam">
                            <p><?php if (isset($name_error)) {
                                echo $name_error;
                               }?></p>
                        </div>
                        <div>
                            <label for="email" class="sr-only">Email:</label>
                            <input type="email" name="email" id="email" autocomplete="email"
                            class="contactFormData block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm"
                            placeholder="Email">
                            <p><?php if (isset($email_error)) {
                                echo $email_error;
                               } ?></p>
                        </div>
                        <div>
                            <label for="subject" class="sr-only">Onderwerp: </label>
                            <input type="text" name="subject" id="subject" autocomplete="tel"
                            class="contactFormData block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm"
                            placeholder="Onderwerp">
                            <p><?php if (isset($subject_error)) {
                                echo $subject_error;
                               } ?></p>
                        </div>
                        <div>
                            <label for="message" class="sr-only">Bericht:</label>
                            <textarea id="message" name="message" rows="4"
                            class="contactFormData block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm"
                            placeholder="Bericht"></textarea>
                            <p><?php if (isset($message_error)) {
                                echo $message_error;
                               } ?></p>
                        </div>
                        <div>
                            <button type="submit" name="submit"
                            class="buttonSubmit rounded p-2">Verzenden</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Einde Contact -->
</body>
    <script src="script.js"></script>
    <script src="mobile.js"></script>
</html>
