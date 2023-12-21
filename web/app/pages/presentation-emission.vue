<template>
    <header>

    </header>
    <navbar>

    </navbar>
    <main>
    <section class="direct">
        <div class="direct-infos">
            <div class="direct-infos-titre">
                <embed src="../assets/direct.svg"/>
                <h1>Nom émission</h1>
            </div>
            <p class="direct-infos-sous-titre">EN DIRECT</p>
            <p class="direct-infos-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            <button class="direct-infos-ecouter">Écouter</button>
        </div>
        <img class="direct-image" src="../assets/Desktop.png" alt="image de l'émission en direct">
    </section>


    <section class="si-direct">
        <div class="si-direct-titre">
            <h2>En direct</h2>
            <embed src="../assets/direct.svg"/>
        </div>
        <div class="si-direct-infos">
            <embed src="../assets/Desktop.png"/>
            <div class="si-direct-infos-texte">
                <h3>Nom de l'émission</h3>
                <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Et magnam optio iusto, eaque quos impedit hic perferendis eius similique a maxime dolor unde fugiat facere, placeat vel ab expedita exercitationem.
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Et magnam optio iusto, eaque quos impedit hic perferendis eius similique a maxime dolor unde fugiat facere, placeat vel ab expedita exercitationem.
                </p>
            </div>
        </div>
    </section>

    <section class="podcasts-emission">
        <h2>Podcasts</h2>
        <div class="episodes">
            <section class="episode">
                <div class="episode-infos">
                    <div>
                        <embed class="play" src="../assets/miniplay.svg">
                        <p class="titre">Nom de l'épisode</p>
                    </div>
                    <div>
                        <p>00:00</p>
                        <embed class="plus" src="../assets/plus.svg">
                    </div>
                    <!--<embed class="croix" src="../assets/croix.svg">-->
                </div>
                <div class="episode-infos-plus">
                    <p><strong>Présentateur : </strong> Nom Prénom</p>
                    <p><strong>Invités : </strong> Nom Prénom, Nom Prénom</p>
                    <p class="date">00/00/0000</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
                </div>
            </section>

            <section class="episode">
                <div class="episode-infos">
                    <div>
                        <embed class="play" src="../assets/miniplay.svg">
                        <p class="titre">Nom de l'épisode</p>
                    </div>
                    <div>
                        <p>00:00</p>
                        <embed class="plus" src="../assets/plus.svg">
                    </div>
                    <!--<embed class="croix" src="../assets/croix.svg">-->
                </div>
                <div class="episode-infos-plus">
                    <p><strong>Présentateur : </strong> Nom Prénom</p>
                    <p><strong>Invités : </strong> Nom Prénom, Nom Prénom</p>
                    <p class="date">00/00/0000</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
                </div>
            </section>

            <section class="episode">
                <div class="episode-infos">
                    <div>
                        <embed class="play" src="../assets/miniplay.svg">
                        <p class="titre">Nom de l'épisode</p>
                    </div>
                    <div>
                        <p>00:00</p>
                        <embed class="plus" src="../assets/plus.svg">
                    </div>
                    <!--<embed class="croix" src="../assets/croix.svg">-->
                </div>
                <div class="episode-infos-plus">
                    <p><strong>Présentateur : </strong> Nom Prénom</p>
                    <p><strong>Invités : </strong> Nom Prénom, Nom Prénom</p>
                    <p class="date">00/00/0000</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
                </div>
            </section>
        </div>
    </section>
    <a href="emission.html">Découvrir d'autres émissions</a>
</main>
<footer>
    
</footer>
</template>

<script setup>
    import navbar from '../components/navBar.js'
    import header from '../components/entete.js'
    import footer from '../components/basPage.js'
</script>