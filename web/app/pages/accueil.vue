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

    <section class="podcasts">
        <div class="titre-fleche">
            <h2>Podcasts</h2>
            <embed src="../assets/fleche.svg"/>
        </div>
        <div class="podcasts-liste">
            <section class="podcast">
                <div class="podcast-info">
                    <p>NOM ÉMISSION</p>
                    <p>Nom de l'épisode</p>
                </div>
                <embed src="../assets/play.svg">
            </section>

            <section class="podcast">
                <div class="podcast-info">
                    <p>NOM ÉMISSION</p>
                    <p>Nom de l'épisode</p>
                </div>
                <embed src="../assets/play.svg">
            </section>


            <section class="podcast">
                <div class="podcast-info">
                    <p>NOM ÉMISSION</p>
                    <p>Nom de l'épisode</p>
                </div>
                <embed src="../assets/play.svg">
            </section>

            <section class="podcast">
                <div class="podcast-info">
                    <p>NOM ÉMISSION</p>
                    <p>Nom de l'épisode</p>
                </div>
                <embed src="../assets/play.svg">
            </section>

            <section class="podcast">
                <div class="podcast-info">
                    <p>NOM ÉMISSION</p>
                    <p>Nom de l'épisode</p>
                </div>
                <embed src="../assets/play.svg">
            </section>
        </div>
    </section>

    <section class="emissions">
        <div class="titre-fleche">
            <h2>Émissions</h2>
            <embed src="../assets/fleche.svg"/>
        </div>
        <div class="emissions-liste">
            <section class="emission">
                <p>Le titre de l'émission</p>
                <p>PRÉSENTATEUR</p>
            </section>


            <section class="emission">
                <p> Le titre de l'émission </p>
                <p>PRÉSENTATEUR</p>
            </section>

            <section class="emission">
                <p>Le titre de l'émission</p>
                <p>PRÉSENTATEUR</p>
            </section>

            <section class="emission">
                <p>Le titre de l'émission</p>
                <p>PRÉSENTATEUR</p>
            </section>

            <section class="emission">
                <p>Le titre de l'émission</p>
                <p>PRÉSENTATEUR</p>
            </section>
        </div>
    </section>
</main>
<footer>
    
</footer>
</template>

<script setup>
    import navbar from '../components/nav'
    import header from '../components/header'
    import footer from '../components/footer'
</script>