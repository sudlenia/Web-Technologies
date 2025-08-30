const messagesList = document.querySelector("#messages");

async function fetchMessages() {
    try {
        const response = await(fetch('/messages'));
        const messages = await response.json();

        messagesList.innerHTML = '';
        messages.forEach(message => {
            const li = document.createElement('li');
            li.innerHTML = `<span>${message.username}:</span> ${message.text}`;
            messagesList.appendChild(li);
        });
    } catch (e) {
        console.error(e);
    }
}

setInterval(fetchMessages, 2000);