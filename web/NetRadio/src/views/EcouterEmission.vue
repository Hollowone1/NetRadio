<template>
  <div>
    <button @click="connectToServer">Connecter au serveur</button>
    <button @click="startStreaming" v-if="isConnected && !isStreaming">Démarrer le Stream</button>
    <button @click="stopStreaming" v-if="isStreaming">Arrêter le Stream</button>
  </div>
</template>

<script>
import { io } from "socket.io-client";
import HeaderComponent from "@/App.vue";
import AudioPlayer from "@/components/AudioPlayer.vue";

export default {
  components: { HeaderComponent, AudioPlayer },
  data() {
    return {
      isConnected: false,
      socket: null,
      audioContext: new (window.AudioContext || window.webkitAudioContext)(),
      mediaStreamSource: null,
      scriptNode: null,
      wavencoder: null,
      isStreaming: false,
    };
  },
  methods: {
    connectToServer() {
      this.socket = io("http://localhost:3000");
      this.socket.on("connect", () => {
        console.log("Connected to server");
        this.isConnected = true;
      });
      this.socket.on("disconnect", () => {
        console.log("Disconnected from server");
        this.isConnected = false;
      });
    },
    startStreaming() {
      navigator.mediaDevices
        .getUserMedia({ audio: true })
        .then((stream) => {
          this.mediaStreamSource = this.audioContext.createMediaStreamSource(stream);
          this.wavencoder = new WavEncoder(this.audioContext.sampleRate, this.audioContext.numberOfChannels);
          this.scriptNode = this.audioContext.createScriptProcessor();
          this.mediaStreamSource.connect(this.scriptNode);
          this.scriptNode.connect(this.audioContext.destination);
          this.scriptNode.onaudioprocess = (audioProcessingEvent) => {
            const inputData = audioProcessingEvent.inputBuffer.getChannelData(0);
            this.wavencoder.encode(inputData);
            if (this.isConnected && this.isStreaming) {
              this.socket.emit("audio", { type: "wav", data: this.wavencoder.getData() });
            }
          };
          this.isStreaming = true;
        })
        .catch((error) => {
          console.error("Error accessing microphone:", error);
        });
    },
    stopStreaming() {
      if (this.scriptNode) {
        this.scriptNode.onaudioprocess = null;
        this.scriptNode.disconnect();
      }
      if (this.mediaStreamSource) {
        this.mediaStreamSource.disconnect();
      }
      this.isStreaming = false;
    },
  },
  mounted() {
    this.connectToServer();
  },
};

class WavEncoder {
  constructor(sampleRate, numberOfChannels, durationInSeconds) {
    this.sampleRate = sampleRate;
    this.numberOfChannels = numberOfChannels;
    this.bufferSize = Math.ceil(sampleRate * numberOfChannels * durationInSeconds);
    this.buffer = new Float32Array(this.bufferSize);
    this.currentSample = 0;
    this.dataLength = 0;
    this.reset();
  }

  reset() {
    this.currentSample = 0;
    this.dataLength = 0;
    this.writeString("RIFF");
    this.writeUint32(0);
    this.writeString("WAVE");
    this.writeString("fmt ");
    this.writeUint32(16);
    this.writeUint16(1);
    this.writeUint16(this.numberOfChannels);
    this.writeUint32(this.sampleRate);
    this.writeUint32(this.sampleRate * this.numberOfChannels * 2);
    this.writeUint16(4);
    this.writeUint16(16);
    this.writeString("data");
    this.writeUint32(0);
  }

  writeUint32(num) {
    if (this.currentSample + 4 <= this.bufferSize) {
      const view = new DataView(this.buffer.buffer);
      view.setUint32(this.currentSample, num, true);
      this.currentSample += 4;
    } else {
      console.error("Buffer overrun!");
    }
  }

  writeUint16(num) {
    if (this.currentSample + 2 <= this.bufferSize) {
      const view = new DataView(this.buffer.buffer);
      view.setUint16(this.currentSample, num, true);
      this.currentSample += 2;
    } else {
      console.error("Buffer overrun!");
    }
  }

  writeString(str) {
    for (let i = 0; i < str.length; i++) {
      this.writeUint16(str.charCodeAt(i));
    }
  }

  write(data) {
    const remainingSpace = this.bufferSize - this.currentSample;
    const writeLength = Math.min(data.length, remainingSpace);

    if (writeLength > 0) {
      this.buffer.set(data.subarray(0, writeLength), this.currentSample);
      this.currentSample += writeLength;
      this.dataLength += writeLength;
    } else {
      console.error("Buffer overrun!");
    }
  }

  getData() {
    this.writeUint32(this.dataLength);
    this.writeUint32(this.dataLength + 36);
    return this.buffer.subarray(0, this.currentSample);
  }
}


</script>
