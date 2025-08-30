const express = require('express');
const mustache = require('mustache-express');
const bodyParser = require('body-parser');
const fs = require('fs');

const aboutData = JSON.parse(fs.readFileSync('./data/about.json', 'utf-8'));
const formData = JSON.parse(fs.readFileSync('./data/form.json', 'utf-8'));
const homeData = JSON.parse(fs.readFileSync('./data/home.json', 'utf-8'));
const sponsorsData = JSON.parse(fs.readFileSync('./data/sponsors.json', 'utf-8'));

const app = express();

app.engine('mustache', mustache());
app.set('view enigne', 'mustache');
app.set('views', __dirname + '\\views');

app.use(bodyParser.urlencoded({ extended: true }));
app.use(express.static(__dirname + '/public'));

app.get('/', (req, res) => {
    res.render('home.mustache', homeData);
});

app.get('/about', (req, res) => {
    res.render('about.mustache', aboutData);
});

app.get('/sponsors', (req, res) => {
    res.render('sponsors.mustache', sponsorsData);
});

app.get('/form', (req, res) => {
    res.render('form.mustache', formData);
});

app.post('/submit', (req, res) => {
    const formData = req.body;
    const formattedData = Object.entries(formData).map(([key, value]) => ({
        field: key,
        value: Array.isArray(value) ? value.join(', ') : value,
    }));
    res.render('product.mustache', { title: "Добавленный продукт", data: formattedData})
});

const PORT = 3000;
app.listen(PORT, () => {
    console.log(`Server running on localhost:${PORT}`)
});
