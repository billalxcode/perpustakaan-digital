import mqtt from "mqtt";

console.log(
    document.getElementById("uuidInput")
)
// const client = mqtt.connect("ws://broker.emqx.io:8083/mqtt")

// console.log("oke gayss")

// client.on("connect", function () {
//     console.log('Terkoneksi dengan MQTT Broker')
//     console.log("Subscribe auth")
//     client.subscribe("catdoom/device/auth")
// })

// client.on("message", (topic, message) => {
//     console.log("Topic: ", topic)
//     document.getElementById("uuidInput").value = message.toString()
// })