class MyAudioWorkletProcessor extends AudioWorkletProcessor {
    constructor() {
      super();
      this.currentGain = 1.0;
    }
  
    process(inputs, outputs, parameters) {
      const input = inputs[0];
      const output = outputs[0];
  
      // Boucle sur chaque échantillon de l'entrée audio
      for (let channel = 0; channel < input.length; channel++) {
        for (let i = 0; i < input[channel].length; i++) {
          // Applique un gain sur l'entrée audio
          output[0][i] = input[channel][i] * this.currentGain;
        }
      }
  
      // Met à jour la valeur du gain pour le prochain traitement audio
      this.currentGain += parameters.gain.value[0];
  
      // Retourne true pour indiquer que le traitement audio est terminé
      return true;
    }
  }
  
  registerProcessor('my-audio-worklet-processor', MyAudioWorkletProcessor);
  
  export { AudioWorklet, MyAudioWorkletProcessor };