<template>
  <section>
<!--    <HeaderComponent />-->
      <div v-if="emission">
        <h1><u>{{emission.titre}} - {{emission.description}}</u></h1>
      </div>
      <div>
        <img src="" alt=""/>
      </div>
      <button @click="quitLive" type="submit" id="btn-stop">
        Quitter le direct
      </button>
      <button @click="reqInvite" type="submit" id="invitation">
        Demander à participer
      </button>
<!--    <Footer />-->
  </section>
</template>

<script>
import { io } from "socket.io-client";
import HeaderComponent from "@/App.vue";
export default {
  components: {HeaderComponent},
  data() {
    return {
      socket: io("http://localhost:3000/"),
      blob: {},
      audio: null,
      id: null,
      invite: false,
      emission : null
    };
  },
  mounted() {
    console.log("You joined the live");
    this.socket.on("voice", (arrayBuffer) => {
      let blob = new Blob([arrayBuffer], { type: "audio/ogg; codecs=opus" });
      let audio = document.createElement("audio");
      audio.src = window.URL.createObjectURL(blob);
      audio.play();
    });
    this.socket.on("voiceInvite", (arrayBuffer) => {
      console.log("test");
      if (this.invite) {
        let blob = new Blob([arrayBuffer], { type: "audio/ogg; codecs=opus" });
        let audio = document.createElement("audio");
        audio.src = window.URL.createObjectURL(blob);
        audio.play();
      }
    });
    this.socket.on("diconnect", () => {
      this.invite = false;
    });
    this.socket.on("authorisation", (invite) => {
      if (this.id === invite.id) {
        if (invite.response) {
          console.log("je suis invité");
          this.invite = invite.response;

          let constraints = {
            audio: true,
          };
          let mediaRecorder;

          navigator.mediaDevices
              .getUserMedia(constraints)
              .then((mediaStream) => {
                mediaRecorder = new MediaRecorder(mediaStream);
                mediaRecorder.onstart = () => {
                  this.chunks = [];
                };

                mediaRecorder.ondataavailable = (e) => {
                  this.chunks.push(e.data);
                  let blob = new Blob(this.chunks, {
                    type: "audio/mp3; codecs=opus",
                  });
                  if (this.invite) {
                    this.socket.emit("radioInvite", blob);
                  }
                };

                mediaRecorder.start();


                setInterval(() => {
                  if (this.invite) {
                    mediaRecorder.stop();
                    mediaRecorder.start();
                  }
                }, 1000);
              });
        } else {
          console.log("Demande refusée !");
        }
      }
    });

    this.$api
        .get("emissions/1") //  + this.$route.params.id
        .then((response) => {
          this.emission = response.data.emission;
          console.log(response.data);
        })
        .catch((error) => {
          console.log(error);
        });
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
      this.socket.emit("invite", { id: this.id, accepted: false });
    },
  },

};
</script>

<style lang="scss">

</style>