

<script>
import AudioRecorder from "@/components/AudioRecorder.vue";
import {io} from "socket.io-client";
import HeaderComponent from "@/App.vue";
import AudioPlayer from "@/components/AudioPlayer.vue";

export default {
  components: {HeaderComponent, AudioRecorder, AudioPlayer},
  data() {
    return {
      socket: io("http://localhost:3000/"),
      blob: {},
      audio: null,
      id: null,
      invite: false,
      emission: null
    };
  },
  mounted() {

    // console.log("You joined the live");
    // this.socket.on("voice", (arrayBuffer) => {
    //   let blob = new Blob([arrayBuffer], { type: "audio/mp3; codecs=opus" });
    //   let audio = document.createElement("audio");
    //   audio.src = window.URL.createObjectURL(blob);
    //   audio.play();
    // });
    // this.socket.on("voiceInvite", (arrayBuffer) => {
    //   console.log("test");
    //   if (this.invite) {
    //     let blob = new Blob([arrayBuffer], { type: "audio/mp3; codecs=opus" });
    //     let audio = document.createElement("audio");
    //     audio.src = window.URL.createObjectURL(blob);
    //     audio.play();
    //   }
    // });
    // this.socket.on("diconnect", () => {
    //   this.invite = false;
    // });
    // this.socket.on("authorisation", (invite) => {
    //   if (this.id === invite.id) {
    //     if (invite.response) {
    //       console.log("je suis invité");
    //       this.invite = invite.response;
    //
    //       let constraints = {
    //         audio: true,
    //       };
    //       let mediaRecorder;
    //
    //       navigator.mediaDevices
    //           .getUserMedia(constraints)
    //           .then((mediaStream) => {
    //             mediaRecorder = new MediaRecorder(mediaStream);
    //             mediaRecorder.onstart = () => {
    //               this.chunks = [];
    //             };
    //
    //             mediaRecorder.ondataavailable = (e) => {
    //               this.chunks.push(e.data);
    //               let blob = new Blob(this.chunks, {
    //                 type: "audio/mp3; codecs=opus",
    //               });
    //               if (this.invite) {
    //                 this.socket.emit("radioInvite", blob);
    //               }
    //             };
    //
    //             mediaRecorder.start();
    //
    //
    //             setInterval(() => {
    //               if (this.invite) {
    //                 mediaRecorder.stop();
    //                 mediaRecorder.start();
    //               }
    //             }, 1000);
    //           });
    //     } else {
    //       console.log("Demande refusée !");
    //     }
    //   }
    // });
    //
    // this.$api
    //     .get("emissions/" + this.$route.params.id) //  + this.$route.params.id
    //     .then((response) => {
    //       this.emission = response.data.emission;
    //       console.log(response.data);
    //     })
    //     .catch((error) => {
    //       console.log(error);
    //     });

    // this.audioContext = new AudioContext();
    // this.gainNode = this.audioContext.createGain();
    // this.gainNode.connect(this.audioContext.destination);
    //
    // this.socket.on("audio", (data) => {
    //   // Convertit l'ArrayBuffer en AudioBuffer
    //   this.audioContext.decodeAudioData(data, (audioBuffer) => {
    //     // Crée un nouveau buffer source et le connecte à l'audio context
    //     const bufferSource = this.audioContext.createBufferSource();
    //     bufferSource.buffer = audioBuffer;
    //     bufferSource.connect(this.gainNode);
    //
    //     // Démarre la lecture du buffer source
    //     bufferSource.start();
    //   });
    // });
  },
  methods: {
    quitLive() {
      this.$router.push({path: "/"});
    },
    reqInvite() {
      const genRanHex = (size) =>
          [...Array(size)]
              .map(() => Math.floor(Math.random() * 16).toString(16))
              .join("");
      this.id = genRanHex(20);
      console.log(this.id);
      this.socket.emit("invite", {id: this.id, accepted: false});
    },
    // playAudio() {
    //   // Emet l'événement audio avec un buffer audio mock
    //   this.socket.emit("audio", new ArrayBuffer(1024));
    // }
  }

};
</script>

<template>
  <section>
    <!--    <HeaderComponent />-->
    <div v-if="emission">
      <h1><u>{{ emission.titre }} </u></h1>
      <p>{{ emission.description }}</p>
      <img :src="emission.photo" alt="image de l'émission en direct">
    </div>

    <button @click="playAudio">Play Audio</button>
    <audio ref="audioElement"></audio>

    <audio-recorder />
    <audio-player />
    <!--    <button @click="play()"> Play</button>-->
    <!--    -->
    <!--    <audio id="audio" src=""></audio>-->
    <!--      <button @click="quitLive" type="submit" id="btn-stop">-->
    <!--        Quitter le direct-->
    <!--      </button>-->
    <!--      <button @click="reqInvite" type="submit" id="invitation">-->
    <!--        Demander à participer-->
    <!--      </button>-->
    <!--    <Footer />-->
  </section>
</template>

<style lang="scss">

</style>