require('dotenv').config();
const express = require('express');
const router = require('./router.js');
const multer = require('multer');
const path = require('path')


const app = express();
const PORT = process.env.PORT || 8001;


const storage = multer.diskStorage({
    destination: (req, file, cb) => {
        cb(null, path.join(__dirname, '../uploads'));
    },
    filename: (req, file, cb) => {
        cb(null, Date.now() + path.extname(file.originalname)); // Append extension
    }
});

const upload = multer({ storage: storage });

// Serve static files
app.use(express.static('public'));

// File upload endpoint
app.post('/upload', upload.single('file'), (req, res) => {
    res.send('File uploaded successfully');
});

// Use the router for handling routes
app.use(router);

const start = async () => {
    try {
        app.listen(PORT, () => {
            console.log('                              +-+-+-+-+-+-+-+-+-+-+');
            console.log('                              | SC Excel Template |');
            console.log('                              +-+-+-+-+-+-+-+-+-+-+');
            console.log('');
            console.log(`Server is running on http://localhost:${PORT}`);
        });
    } catch (err) {
        console.error(err);
        process.exit(1);
    }
};

module.exports = { start };
