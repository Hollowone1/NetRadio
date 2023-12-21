<template>
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

        <div class="resultats">
            <h2>Résultats de votre recherche</h2>
            <div class="barre-recherche">
                <img src="../assets/loupe.svg" alt="icone recherche">
                <input type="text" placeholder="Rechercher">
            </div>
            <div class="podcasts-liste">
                <section class="podcast">
                    <div class="podcast-info">
                        <p>Nom de l'émission</p>
                        <p>Titre du podcast</p>
                    </div>
                    <embed src="../assets/play.svg">
                </section>

                <section class="podcast">
                    <div class="podcast-info">
                        <p>Nom de l'émission</p>
                        <p>Titre du podcast</p>
                    </div>
                    <embed src="../assets/play.svg">
                </section>

                <section class="podcast">
                    <div class="podcast-info">
                        <p>Nom de l'émission</p>
                        <p>Titre du podcast</p>
                    </div>
                    <embed src="../assets/play.svg">
                </section>

                <section class="podcast">
                    <div class="podcast-info">
                        <p>Nom de l'émission</p>
                        <p>Titre du podcast</p>
                    </div>
                    <embed src="../assets/play.svg">
                </section>
            </div>
        </div>
    </main>
</template>