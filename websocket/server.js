import http from 'http';
import { Server as SocketServer } from 'socket.io';
import fs from 'fs';
// import * as fs from "fs";

//crée un serveur http utilisé pour écouter les connexions entrantes des clients
const server = http.createServer();

// crée un serveur web socket en utilisant la classe socket serveur
const io = new SocketServer(server, {
    // configuration cors pour autoriser toutes les origines * et les méthodes http get et post
    cors: {
        origin: "*", // Autorise toutes les origines
        methods: ["GET", "POST"] // Autorise les méthodes GET et POST
    }
});


io.on("connection", (socket) => {
    console.log("User connected");

    // // Envoie des données audio à tous les clients connectés
    // socket.on("audio", (data) => {
    //     // socket.broadcast.emit("audio", data);
    //     io.emit('audio', data);
    //     console.log(data);
    // });

    // Créer un flux de données pour chaque utilisateur
    const stream = fs.createWriteStream(`user-${socket.id}.wav`);

    socket.on('audio', (data) => {
        // Écrire les données audio dans le flux
        stream.write(data);

        // Diffuser les données audio à tous les clients connectés, y compris l'émetteur
        io.emit('audio', data);
    });

    socket.on('disconnect', () => {
        console.log('Utilisateur déconnecté');
        // Fermer le flux lorsque l'utilisateur se déconnecte
        stream.end();
    });
});
//
// io.on("connection", (socket) => {
//     // console.log("Un utilisateur s'est connecté")
//     //
//     // // Ecouter les déconnexion
//     // socket.on("disconnect", (reason) => {
//     //     console.log(`Un utilisateur s'est déconnecté. ${reason}`);
//     // });
//     //
//     // // AUDIO animateur
//     // socket.on('radio', function(blob) {
//     //     socket.broadcast.emit('voice', blob);
//     // });
//     //
//     // // AUDIO invité
//     // socket.on('radioInvite', function(blob) {
//     //     socket.broadcast.emit('voiceInvite', blob);
//     // });
//     //
//     // // l'invité demande la parole
//     // socket.on('invite', function(invite) {
//     //     console.log("demande invité en cours !");
//     //     socket.broadcast.emit('choise', invite);
//     // });
//     //
//     // // déconnecter invité
//     // socket.on('inviteDeconnecter', function() {
//     //     console.log("Un invité a était déconnecter");
//     //     socket.broadcast.emit('diconnect');
//     // })
//     //
//     // // l'animateur donne le droit a la parole a l'invité
//     // socket.on('giveVoice', function(invite) {
//     //     console.log("demande accorder a " + invite.id + " est " + invite.response);
//     //     socket.broadcast.emit('authorisation', invite);
//     // });
//
//
//
// });

// Démarrage du serveur HTTP sur le port 3000
server.listen(3000, () => {
    console.log('Server running on port 3000');
});