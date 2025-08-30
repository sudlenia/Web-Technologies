import express from "express";
import { BOT_TOKEN } from "./token.js";
import fetch from "node-fetch";

const app = express();

const PORT = 3000;

let lastUpdateId = 0;
let messages = [];

const sendMessage = async (chatId, text) => {
  try {
    await fetch(`https://api.telegram.org/bot${BOT_TOKEN}/sendMessage`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ chat_id: chatId, text })
    });
  } catch (e) {
    console.error(e);
  }
};

const handleUpdate = async (update) => {
  if (update.message) {
    const chatId = update.message.chat.id;
    const firstName = update.message.from.first_name;

    const responseText = `${firstName}, спасибо за сообщение!`;
    await sendMessage(chatId, responseText);
  }
};

const getUpdates = async () => {
  try {
    const response = await fetch(
      `https://api.telegram.org/bot${BOT_TOKEN}/getUpdates?offset=${
        lastUpdateId + 1
      }`
    );
    const data = await response.json();

    if (data.ok) {
      for (const update of data.result) {
        const message = update.message;

        if (message) {
          const text = message.text;
          const username = message.from.first_name;

          console.log(`New message by ${username}: "${text}"`);

          messages.push({ username, text });

          await handleUpdate(update);

          lastUpdateId = update.update_id;
        }
      };
    }
  } catch (e) {
    console.error(e);
  }
};

setInterval(getUpdates, 2000);

app.get("/messages", (req, res) => {
  res.json(messages);
});

app.use(express.static("public"));

app.listen(PORT, () => {
  console.log(`Server running on ${PORT}`);
});
