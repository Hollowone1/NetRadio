const navBar = {
    template: `
<nav class="nav">
    <div class="nav-item"><router-link to="./podcasts.html">Podcasts</router-link></div>
    <div class="nav-item"><router-link to="./emissions.html">Émissions</router-link></div>
    <div class="nav-item"><router-link to="./programmation.html">Grille des programmes</router-link></div>
</nav>
<div class="topnav">
<div id="myLinks">
    <div class="nav-item"><router-link to="./podcasts.html">Podcasts</router-link></div>
    <div class="nav-item"><router-link to="./emissions.html">Émissions</router-link></div>
    <div class="nav-item"><router-link to="./programmation.html">Grille des programmes</router-link></div>
</div>
<a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="gg-menu"></i>
</a>
</div>`,
}

export default navBar;

