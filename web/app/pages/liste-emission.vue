<template>
    <header>

    </header>
    <navbar>

    </navbar>
<main>
        <section>
                <i></i>
                <h2>Nom Emission</h2>
                <span>En direct</span>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
                    Nostrum minima in rem natus non expedita, 
                    saepe commodi neque facere molestiae ipsam harum. 
                    Inventore voluptatum praesentium adipisci numquam deleniti totam sapiente!
                </p>
                <button><i></i>Ecoutez</button>
                <img src="../assets/Desktop.png" alt="emission en direct">
            </section>
            <section>
                <h2>Résultats de votre recherche</h2>
                <input type="text" placeholder="Rechercher">
                <div class="allGenre">
                    <div class="genre">
                        genre 1
                    </div>
                    <div class="genre">
                        genre 2
                    </div>
                    <div class="genre">
                        genre 3
                    </div>
                    <div class="genre">
                        genre 4
                    </div>
                </div>
            </section>
            <section>
                <div class="allEmission">
                    <div class="emission">
                        <h4>le titre de l'émission</h4>
                        <span>Présentateur</span>
                    </div>
                    <div class="emission">
                        <h4>le titre de l'émission</h4>
                        <span>Présentateur</span>
                    </div>
                    <div class="emission">
                        <h4>le titre de l'émission</h4>
                        <span>Présentateur</span>
                    </div>
                </div>
        </section>
    </main>
    <footer>
        
    </footer>
</template>

<script setup>
    import navbar from '../components/navBar.js'
    import header from '../components/entete.js'
    import footer from '../components/basPage.js'
</script>