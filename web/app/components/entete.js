const entete = {
    template: `<header>
    <div class="header">
        <img class="header-logo" src="../../assets/img/logo.png" alt="Logo NET RADIO">
        <div class="header-boutons">
            <input class="search" type="search" src="../../assets/img/search.svg" placeholder="Search for...">
            <!--si on est  connecté-->
            <img class="header-user-co" src="../../assets/img/user.svg"/>
            <!--si on n'est pas connecté-->
            <button class="header-boutons-connecter">Se connecter</button>
        </div>
    </div>
    <nav class="nav">
        <div class="nav-item"><a href="./podcasts.html">Podcasts</a></div>
        <div class="nav-item"><a href="./emissions.html">Émissions</a></div>
        <div class="nav-item"><a href="./programmation.html">Grille des programmes</a></div>
    </nav>
</header>
<div class="topnav">
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="gg-menu"></i>
    </a>
    <div id="myLinks">
        <div class="nav-item"><a href="./podcasts.html">Podcasts</a></div>
        <div class="nav-item"><a href="./emissions.html">Émissions</a></div>
        <div class="nav-item"><a href="./programmation.html">Grille des programmes</a></div>
    </div>
</div>`
}

export default entete;