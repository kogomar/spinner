const currentUrl = window.location.href;
const parts = currentUrl.split('/');
const token = parts[parts.length - 1];
const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

const headers = {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
        'X-CSRF-TOKEN': csrfToken,
    };

document.getElementById('sendRequestBtn').addEventListener('click', function() {
    const spinner = document.getElementById('spinner');
    const resultBlock = document.getElementById('result');
    const resultText = document.getElementById('result-text');
    const resultNumber = document.getElementById('result-number');
    const resultAmount = document.getElementById('result-amount');

    spinner.style.display = "block"
    resultBlock.style.display = "none"

    fetch('/game/spin', {
        method: 'POST',
        headers,
        body: JSON.stringify({})
    })
        .then(response => {
            return response.json();
        })
        .then(data => {
            spinner.style.display = "none"
            resultBlock.style.display = "block"

            resultText.innerText = data.data.isWinner ? 'Win' : 'Lose';
            resultText.style.color = data.data.isWinner ? 'green' : 'red';
            resultNumber.innerText = 'Your number is: ' + data.data.spin;
            resultAmount.innerText = 'You won: ' + data.data.win;
        })
        .catch(error => {
            console.error('Error:', error);
        });
});

document.getElementById('generateUrlBtn').addEventListener('click', function() {
    fetch('/token/generate', {
        method: 'POST',
        headers,
        body: JSON.stringify({})
    })
        .then(response => {
            return response.json();
        })
        .then(data => {
            const urlList = document.querySelector('.url-list');
            const listItem = document.createElement('li');
            listItem.classList.add('url-item');

            const changeButton = document.createElement('button');
            changeButton.classList.add('button');
            changeButton.textContent = 'Change Status';
            changeButton.onclick = changeStatus(data.data.id, data.data.status);

            const urlLink = document.createElement('a');
            urlLink.href = data.data.url;
            urlLink.textContent = data.data.url;

            listItem.appendChild(changeButton);
            listItem.appendChild(urlLink);
            urlList.appendChild(listItem);
        })
        .catch(error => {
            console.error('Error:', error);
        });
});

function changeStatus(tokenId, isActive) {
    const status = isActive > 0 ? 'disable' : 'enable';

    fetch(`/token/${tokenId}/status/${status}`, {
        method: 'POST',
        headers,
        body: JSON.stringify({})
    })
        .then()
        .then(data => {
            const elements = document.querySelectorAll(`[data-token='${tokenId}']`);
            elements.forEach(element => {
                if (status === 'disable') {
                    element.classList.add('url-disabled');
                } else {
                    element.classList.remove('url-disabled');
                }
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
