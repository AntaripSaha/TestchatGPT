<template>
    <div class="container home mt-5">
      <h2>ChatGPT</h2>
      <textarea v-model="userInput" rows="5" cols="50" placeholder="Type your message..."></textarea>
      <button type="button" class="btn btn-primary mt-4" @click="sendMessage">Send</button>
      <div v-if="response">
        <h3>Response:</h3>
        <p>{{ response }}</p>
      </div>
      <button type="button" class="btn btn-secondary mt-4" @click="logout">Logout</button>
    </div>
  </template>
  
  <script>
  import { ref } from "vue";
  import { useRouter } from "vue-router";
  import axios from "axios";
  
  export default {
    setup() {
    const router = useRouter();
    const userInput = ref("");
    const response = ref("");
  
    function logout() {
        localStorage.removeItem("token");
        router.push({ name: "Home" });
    }
  
    async function sendMessage() {
        try {
            const res = await axios.post("/api/chat", { message: userInput.value });
            if (res.data && res.data.choices && res.data.choices.length > 0) {
            response.value = res.data.choices[0].message.content;
            } else {
            response.value = "Unexpected response format.";
            }
        } catch (error) {
            console.error("Error sending message:", error);
            response.value = "Error occurred while sending message.";
        }
    }

  
    return {
        userInput,
        response,
        sendMessage,
        logout,
      };
    },
  };
  </script>
  
  <style>
  .container {
    max-width: 600px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }
  textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
  }
  </style>
  