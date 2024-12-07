//selecting all required elements
const dropArea = document.querySelector(".drag-area"),
    dragText = dropArea.querySelector("header"),
    button = document.querySelector("button"),
    input = dropArea.querySelector("input"),
    icon = dropArea.querySelector(".icon"),
    sensitive = document.querySelector(".sensitive"),
    nonsensitive = document.querySelector(".non-sensitive"),
    progressStatus = document.querySelector("#progressStatus"),
    progressBar = document.querySelector("#progressBar");

const signUpButton=document.getElementById('signUpButton');
const signInButton=document.getElementById('signInButton');
const signInForm=document.getElementById('signIn');
const signUpForm=document.getElementById('signup');


toggle = document.querySelector(".toggle-button");
navlinks = document.querySelector(".navbar-links");

// Navbar toggle button
toggle.addEventListener('click', () => {
    navlinks.classList.toggle('active');
});

button.onclick = () => {
    input.click();
}


var loadFile = function(event, count) {
    if (count > 0) {
        var image = document.getElementById('output');
        const photo = event.target.files[0];
        if (photo !== undefined) {
            dropArea.classList.add("active");
            sensitive.style.display = "none";
            nonsensitive.style.display = "none";
            progressStatus.style.display = "none";
            progressBar.style.display = "none";
            progressBar.style.width = '0%';
            progressBar.innerHTML = '0%';
            let fileType = photo.type; //getting selected file type
            let validExtensions = ["image/jpeg", "image/jpg", "image/png"]; //adding some valid image extensions in array

            if (validExtensions.includes(fileType)) {
                const photoURL = URL.createObjectURL(photo);
                image.src = photoURL;
                image.style.display = "block";
                icon.style.display = "none";
                dragText.style.display = "none";
                progressStatus.style.display = "block";
                progressBar.style.display = "block";
                setTimeout(() => {
                    classify();
                }, 150);
            } else {
                alert("This is not an Image File!");
                dropArea.classList.remove("active");
                dragText.style.display = "block";
                icon.style.display = "block";
                image.style.display = "none";
            }
        }
    } else {
        alert("Not enough credits, Please upgrade")
    }
};

// Dark Mode toggle
const chk = document.getElementById('chk');
chk.addEventListener('change', () => {
    document.body.classList.toggle('dark');
});

const classify = async() => {
    var image = document.getElementById('output');
    imagePrediction = classifyImage(image);
    textPrediction = extractText(image)
        .then((text) => {
            return classifyText(text);
        });
    let image_conf = 0;
    let text_conf = 0;
    await imagePrediction.then((value) => {
        image_conf = value;
        console.log("Image confidence = ", value);
        for (let i = 0; i <= 50; i++) {
            progressBar.style.width = i + '%';
            progressBar.innerHTML = i + '%';
        }
    });
    await textPrediction.then((value) => {
        text_conf = value;
        console.log("Text confidence = ", value);
    });
    progressStatus.style.display = "none";
    progressBar.style.display = "none";
    updateCount();
    if (image_conf > 0.5 || text_conf > 0.5) {
        sensitive.style.display = "block";
        console.log("Sensitive");
    } else {
        nonsensitive.style.display = "block";
        console.log("Non-sensitive");
    }
}

const extractText = async function(image) {
    let prgs = 0;
    let text = await Tesseract.recognize(
        image.src,
        'eng', {
            logger: (m) => {
                if (m.status === "recognizing text") {
                    prgs = 50 + Math.ceil(m.progress * 100) / 2;
                    progressBar.style.width = prgs + '%';
                    progressBar.innerHTML = prgs + '%';
                }
            }
        }
    ).then(({ data: { text } }) => {
        return text;
    });
    text = text.replace(/[\r\n]+/g, " ");
    console.log("Length of text:", text.length);
    return text;
}

const classifyImage = async function(image) {
    let tensor = tf.browser.fromPixels(image)
        .resizeBilinear([150, 150])
        .div(tf.scalar(255))
        .expandDims(0);

    const classification = await image_model
        .predict(tensor)
        .data()
        .then((value) => { return value; });
    return classification;
}

const classifyText = async function(text) {
    console.log(text)
    const max_length = 60;
    const tokens = text.split(" ");
    const word_index = await fetch('./webapp/public/models/text_model/word_index.json')
        .then(response => {
            return response.json();
        });
    console.log(word_index)
    let padded = new Array(max_length).fill(0);
    for (let i = 0; i < max_length; i++) {
        let tokenid = word_index[tokens[i].toLowerCase()]
        padded[i] = (tokenid === undefined) ? 1 : tokenid;
        if (i == tokens.length - 1)
            break;
    }
    let tensor = tf.tensor([padded]);

    const classification = await text_model
        .predict(tensor)
        .data()
        .then((value) => { return value; });
    return classification;
}

function updateCount() {
    // Send a request to the PHP script to update the count
    fetch('updateCount.php', {
        method: 'GET', // Using GET since you are not sending data in the body
        headers: {
            'Content-Type': 'application/json' // Optional header
        }
    })
    .then(response => response.text()) // Expecting text response (Success/Error message)
    .then(result => {
        if (result === "Success") {
            console.log("Count successfully decreased");
            // You can update the UI here to reflect the updated count
        } else {
            console.error("Error decreasing count: " + result);
        }
    })
    .catch(error => {
        console.error("Error: " + error);
    });
}
    
function handleClick(count) {
    if (count > 0){
    console.log("Hello")
    console.log(count)
    const inputText = document.getElementById('input_text').value;
    console.log(inputText)

    classifyText(inputText).then(classification => {
        if (classification > 0.5) {
            document.getElementById('text_output').textContent = `Sensitive: ${classification}`;
            console.log("Sensitive");
        } else {
            document.getElementById('text_output').textContent = `Non - Sensitive: ${classification}`;
            console.log("Non-sensitive");
        }
        console.log(classification)
        updateCount();
     
    }).catch(error => {
        console.error('Error classifying text:', error);
        document.getElementById('text_output').innerText = 'Error classifying text. Check the console for more information.';
    });
}
else
{
    alert("Not enough credits, Please upgrade")
}
}
const setupPage = async() => {
    text_model = await tf.loadLayersModel('./webapp/public/models/text_model/model.json');
    image_model = await tf.loadLayersModel('./webapp/public/models/image_model/model.json')
}

setupPage();