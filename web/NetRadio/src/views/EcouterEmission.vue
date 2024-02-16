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
      emission: null,
      userInput: "",
      microphoneState: null,
      audioContext: new AudioContext(),
      mediaStreamSource: null,
      micImage: null
    };
  },
  methods: {
    async setupAudioStream() {
      try {
        const stream = await navigator.mediaDevices.getUserMedia({audio: true});
        this.audioContext = new (window.AudioContext || window.webkitAudioContext)(); // || window.webkitAudioContext)
        this.audioContext.latencyHint = 'interactive'; // or 'playback'

        this.mediaStreamSource = this.audioContext.createMediaStreamSource(stream);
      } catch (error) {
        console.error('Error accessing microphone:', error);
      }
    },
    toggleMicrophone() {
      if (this.micImage.classList.contains('bi-mic-mute')) {
        this.micImage.classList.remove('bi-mic-mute');
        this.micImage.classList.add('bi-mic');
        this.microphoneState.textContent = "Unmuted";

        // Connect the media stream source to the audio context destination
        //mediaStreamSource.connect(audioContext.destination);

        // Start sending audio data to the server in real-time
        this.startStreaming();
      } else {
        this.micImage.classList.remove('bi-mic');
        this.micImage.classList.add('bi-mic-mute');
        this.microphoneState.textContent = "Muted";

        // Stop sending audio data to the server
        this.stopStreaming();
      }
    },
    startStreaming() {
      if (!this.mediaStreamSource) {
        return;
      }
      const bufferSize = 2048;

      const scriptNode = this.audioContext.createScriptProcessor(bufferSize, 1, 1);

      scriptNode.onaudioprocess = (audioProcessingEvent) => {
        const inputBuffer = audioProcessingEvent.inputBuffer;
        const audioData = inputBuffer.getChannelData(0);

        // Send the audio data to the server
        if (!this.micImage.includes('bi-mic-mute')) {
          this.socket.emit("audio", audioData);
        }
      };

      this.mediaStreamSource.connect(scriptNode);
      scriptNode.connect(this.audioContext.destination);
    },
    stopStreaming() {
      // Disconnect the script node from the audio context
      if (this.mediaStreamSource && this.mediaStreamSource.isConnected) {
      this.mediaStreamSource.disconnect();
      }
    },
  },
  mounted() {
    this.microphoneState = document.getElementById('microphone-state');
    this.micImage = document.getElementById('mic-image');
    window.onload = function () {
      do {
        this.userInput = prompt("Enter Your name");
        this.socket.emit("joinedusername", this.userInput)
      } while (userInput === null || this.userInput === "");

      this.socket.username = this.userInput;

      this.setupAudioStream();
    }

    this.socket.on("allonlineusers", (myArray) => {
      const fixedDiv = document.querySelector(".fixed");

      fixedDiv.innerHTML = "";

      myArray.forEach((user) => {
        const joinedUserDiv = document.createElement("div");
        joinedUserDiv.className = "joineduser";

        const h2Element = document.createElement("h2");

        const userSpan = document.createElement("span");
        userSpan.textContent = user;

        h2Element.appendChild(userSpan);

        joinedUserDiv.appendChild(h2Element);

        fixedDiv.appendChild(joinedUserDiv);
      });
    });
    this.socket.on("audio1", (data) => {
      const audioContext1 = new (window.AudioContext || window.webkitAudioContext)();

      const typedArray = new Float32Array(data);

      const audioBuffer = audioContext1.createBuffer(1, typedArray.length, audioContext1.sampleRate);

      const channelData = audioBuffer.getChannelData(0);

      channelData.set(typedArray);

      const audioBufferSource = audioContext1.createBufferSource();
      audioBufferSource.buffer = audioBuffer;
      audioBufferSource.connect(audioContext1.destination);

      audioBufferSource.start();
    });
  }


}
;
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