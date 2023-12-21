const header = {
    template: `<div class="header">
    <img class="header-logo" src="..." alt="Logo NET RADIO">
    <div class="header-boutons">
        <input class="search" type="search" src="../assets/search.svg" placeholder="Search for...">
        <!--si on est  connecté-->
        <embed class="header-user-co" src="../assets/user.svg"/>
        <!--si on n'est pas connecté-->
        <button class="header-boutons-connecter">Se connecter</button>
    </div>
</div>`,
}

export default header;