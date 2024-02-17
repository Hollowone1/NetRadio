<script>
import {io} from "socket.io-client";
import HeaderComponent from "@/App.vue";
import AudioPlayer from "@/components/AudioPlayer.vue";
import {AudioWorklet, AudioWorkletNode} from "@/plugin/audio-worklet.js";

export default {
  components: {HeaderComponent, AudioPlayer},
  data() {
    return {
      socket: null,
      audioContext: new AudioContext(),
      audioWorkletNode: null,
      mediaStreamSource: null,
    };
  },
  methods: {
    setupAudioStream() {
      navigator.mediaDevices.getUserMedia({audio: true})
        .then(stream => {
          this.mediaStreamSource = this.audioContext.createMediaStreamSource(stream);
          this.startStreaming();
        })
        .catch(error => {
          console.error('Error accessing microphone:', error);
        });
    },
    startStreaming() {
      if (!this.mediaStreamSource) {
        return;
      }
      const bufferSize = 2048;

      this.audioWorkletNode = new AudioWorkletNode(this.audioContext, 'audio-processor');

      this.mediaStreamSource.connect(this.audioWorkletNode);
      this.audioWorkletNode.connect(this.audioContext.destination);

      this.audioWorkletNode.port.onmessage = (event) => {
        if (event.data && event.data.type === 'audio') {
          this.audioContext.decodeAudioData(event.data.data.buffer, (buffer) => {
            const source = this.audioContext.createBufferSource();
            source.buffer = buffer;
            source.connect(this.audioContext.destination);
            source.start(0);
          });
        }
      };

      this.audioContext.audioWorklet.addModule('/audio-worklet.js')
        .then(() => {
          console.log('AudioWorkletNode added');
        })
        .catch(error => {
          console.error('Error adding AudioWorkletNode:', error);
        });
    },
    connectToServer() {
      this.socket = io("http://localhost:3000");
      this.socket.on("connect", () => {
        console.log("Connected to server");
      });
      this.socket.on("disconnect", () => {
        console.log("Disconnected from server");
      });
      this.socket.on("audio", (data) => {
        this.audioWorkletNode.port.postMessage({type: 'audio', data: {buffer: data}});
      });
    },
  },
  mounted() {
    this.setupAudioStream();
    this.connectToServer();
  },
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

    <button id="microphone-icon" @click="toggleMicrophone()">Muted</button>
    <p id="microphone-state">Muted</p>
    <i class="bi bi-mic-mute" id="mic-image"></i>

    <div class="userlist">
      <div class="header">
        <h2>Joined Users</h2>
      </div>
      <div class="fixed">
      </div>
    </div>
  </section>


</template>

<style lang="scss">

</style>